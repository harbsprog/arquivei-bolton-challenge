<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Repositories\NfesRepositoryInterface;
use App\Repositories\ArquiveiRepositoryInterface;
use Exception;

class NfeSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $arquivei;
    private $nfe;
    private $status;
    private $urlCursor;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $status, string $urlCursor = null)
    {
        $this->status = $status;
        $this->urlCursor = $urlCursor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(NfesRepositoryInterface $nfe, ArquiveiRepositoryInterface $arquivei)
    {
        $this->arquivei = $arquivei;
        $this->nfe = $nfe;

        $responseSandbox = $this->arquivei->get($this->status, $this->urlCursor);

        if ($responseSandbox == 'rate_limit_reached') {

            $this->fail(new Exception($responseSandbox));
        }
        if (isset($responseSandbox->data) && is_array($responseSandbox->data) && count($responseSandbox->data) > 0) {

            dispatch((new NfeSyncJob($this->stus, $responseSandbox->page->next))
                ->onConnection('beanstalkd')
                ->onQueue('nfeSync')->delay(1));

            foreach ($responseSandbox->data as $content) {

                $parsedContent = new \stdClass();
                $parsedContent->xml_content = $content->xml;
                $parsedContent->access_key = $content->access_key;
                $parsedContent->total_value = $this->arquivei->getPriceOnXml($content->xml);
            }
        }
    }
}
