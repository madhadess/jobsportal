<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\ServiceRequest;

class MatchingFailed extends Notification
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
            'type' => 'matching_failed',
            'title' => 'Eşleşme Bulunamadı',
            'message' => '#' . $this->serviceRequest->request_number . ' numaralı talebiniz için şu an uygun personel bulunamadı. Müşteri temsilcimiz sizinle iletişime geçecektir.',
            'url' => route('home-services.request-detail', $this->serviceRequest->request_number),
            'request_id' => $this->serviceRequest->id
        ];
    }
}
