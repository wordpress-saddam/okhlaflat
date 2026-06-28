<?php

namespace App\Notifications;

use App\Models\VisitRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VisitRequestSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $visitRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(VisitRequest $visitRequest)
    {
        $this->visitRequest = $visitRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $property = $this->visitRequest->property;
        $propertyTitle = $property ? $property->title : 'General Consultation';
        $propertyCode = $property ? " ({$property->property_code})" : '';

        return (new MailMessage)
            ->subject('Office Visit Request Received - OkhlaFlat')
            ->greeting("Hello {$notifiable->name},")
            ->line('We have received your request for a physical office visit.')
            ->line("Property: **{$propertyTitle}{$propertyCode}**")
            ->line($this->visitRequest->customer_notes ? "Your notes: \"{$this->visitRequest->customer_notes}\"" : '')
            ->line('Our admin team will assign an agent to assist you with the booking, property verification, and office coordination shortly.')
            ->action('View My Dashboard', route('customer.dashboard'))
            ->line('Thank you for choosing OkhlaFlat!');
    }
}
