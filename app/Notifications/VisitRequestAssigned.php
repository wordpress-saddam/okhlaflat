<?php

namespace App\Notifications;

use App\Models\VisitRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VisitRequestAssigned extends Notification implements ShouldQueue
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
        $agent = $this->visitRequest->agent;
        $property = $this->visitRequest->property;
        $propertyTitle = $property ? $property->title : 'General Consultation';

        return (new MailMessage)
            ->subject('Agent Assigned to Your Visit Request - OkhlaFlat')
            ->greeting("Hello {$notifiable->name},")
            ->line("An agent has been assigned to coordinate your office visit request for **{$propertyTitle}**.")
            ->line("Assigned Agent: **{$agent->name}**")
            ->line("Agent Contact Number: **{$agent->mobile}**")
            ->line("Email: **{$agent->email}**")
            ->line('Your agent will reach out to you shortly to schedule the physical visit to our office.')
            ->action('View My Dashboard', route('customer.dashboard'))
            ->line('Thank you for choosing OkhlaFlat!');
    }
}
