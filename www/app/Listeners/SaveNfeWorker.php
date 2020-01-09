<?php

namespace App\Listeners;

use App\Events\Worker;
use App\Repositories\NfesRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveNfeWorker
{

    protected $nfe;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NfesRepositoryInterface $nfe)
    {
        $this->nfe = $nfe;
    }

    /**
     * Handle the event.
     *
     * @param  Worker  $event
     * @return void
     */
    public function handle(Worker $event)
    {
        $this->nfe->store($event);
    }
}
