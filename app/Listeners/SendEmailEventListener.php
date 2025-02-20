<?php

namespace App\Listeners;

use App\Mail\AlumniCreation;
use App\Mail\TrackerNotification;
use App\Mail\AccountVerification;
use App\Events\SendEmailEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailEventListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(SendEmailEvent $event)
    {
        switch ($event->type) {
            case 'alumni_creation':
                \Mail::to($event->data->email)->send(
                    new AlumniCreation($event->data)
                );

                break;

            case 'tracker_notification':
                foreach($event->data as $index => $alumni){
                     \Mail::to($alumni->email)->send(
                        new TrackerNotification($alumni)
                    );
                }
                break;

            
             case 'account_verification':
                \Mail::to($event->data->email)->send(
                        new AccountVerification($event->data)
                    );
    
                break;
            
            default:
                // code...
                break;
        }
    }
}
