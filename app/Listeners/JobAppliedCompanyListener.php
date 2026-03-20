<?php

namespace App\Listeners;

use Mail;
use App\Events\JobApplied;
use App\Mail\JobAppliedCompanyMailable;
use Illuminate\Queue\InteractsWithQueue;

class JobAppliedCompanyListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  JobApplied  $event
     * @return void
     */
    public function handle(JobApplied $event)
    {
        Mail::send(new JobAppliedCompanyMailable($event->job, $event->jobApply));
    }

}
