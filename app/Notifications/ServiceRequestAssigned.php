<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\ServiceRequest;

class ServiceRequestAssigned extends Notification
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
        $personnelName = $this->serviceRequest->matchedPersonnel ? $this->serviceRequest->matchedPersonnel->name : 'Bir personel';
        return [
            'type' => 'service_request_assigned',
            'title' => 'Personel Atandı!',
            'message' => 'Talebiniz için ' . $personnelName . ' atandı. Detayları görmek için tıklayın.',
            'url' => route('home-services.request-detail', $this->serviceRequest->request_number),
            'request_id' => $this->serviceRequest->id
        ];
    }
}
