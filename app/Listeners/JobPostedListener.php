<?php

namespace App\Listeners;

use Mail;
use App\Events\JobPosted;
use App\Mail\JobPostedMailable;
use App\Mail\JobPostedMailableFront;
use Illuminate\Queue\InteractsWithQueue;

class JobPostedListener
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
     * @param  JobPosted  $event
     * @return void
     */
    public function handle(JobPosted $event)
    {
        Mail::send(new JobPostedMailableFront($event->job));
        Mail::send(new JobPostedMailable($event->job));
    }

}
