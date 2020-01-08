<?php

namespace App\Console\Commands\Nfe;

use App\Jobs\NfeSyncJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Synchronization extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nfe:synchronization {status?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command synchronizes NFEs via Arquivei sandbox endpoint';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $status = $this->argument('status') ?? 'received';

        Log::info('Dispatching');

        dispatch((new NfeSyncJob($status))
            ->onConnection('beanstalkd')
            ->onQueue('nfeSync')->delay(1));

        Log::info('Job to sync NFe dispatched!');
    }
}
