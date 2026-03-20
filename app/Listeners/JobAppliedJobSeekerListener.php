<?php

namespace App\Listeners;

use Mail;
use App\Events\JobApplied;
use App\Mail\JobAppliedJobSeekerMailable;
use Illuminate\Queue\InteractsWithQueue;

class JobAppliedJobSeekerListener
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
        Mail::send(new JobAppliedJobSeekerMailable($event->job, $event->jobApply));
    }

}
