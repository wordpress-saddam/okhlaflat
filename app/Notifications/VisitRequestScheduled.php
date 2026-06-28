<?php

namespace App\Notifications;

use App\Models\VisitRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VisitRequestScheduled extends Notification implements ShouldQueue
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
        $scheduledAt = $this->visitRequest->scheduled_at 
            ? $this->visitRequest->scheduled_at->format('M d, Y \a\t h:i A')
            : 'To be confirmed';

        return (new MailMessage)
            ->subject('Office Visit Scheduled - OkhlaFlat')
            ->greeting("Hello {$notifiable->name},")
            ->line("Your physical office visit for **{$propertyTitle}** has been scheduled.")
            ->line("Scheduled Time: **{$scheduledAt}**")
            ->line("Assigned Agent: **{$agent->name}**")
            ->line("Agent Mobile: **{$agent->mobile}**")
            ->line('Please visit our physical office at Jamia Nagar at the scheduled time. Our agent will guide you through the property details and coordination.')
            ->action('View My Dashboard', route('customer.dashboard'))
            ->line('Thank you for choosing OkhlaFlat!');
    }
}
