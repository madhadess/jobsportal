<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\ServiceRequest;

class ServiceRequestMatched extends Notification
{
    use Queueable;

    protected $serviceRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ServiceRequest $serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'service_request_matched',
            'title' => 'Yeni İş Atandı!',
            'message' => 'Tebrikler! #' . $this->serviceRequest->request_number . ' numaralı talep size atandı. Detayları incelemek için tıklayın.',
            'url' => route('personnel.assignment_details', $this->serviceRequest->id),
            'request_id' => $this->serviceRequest->id
        ];
    }
}
