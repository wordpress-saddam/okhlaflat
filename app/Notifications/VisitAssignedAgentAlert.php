<?php

namespace App\Notifications;

use App\Models\VisitRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VisitAssignedAgentAlert extends Notification implements ShouldQueue
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
        $customer = $this->visitRequest->customer;
        $property = $this->visitRequest->property;
        $propertyTitle = $property ? $property->title : 'General Consultation';

        return (new MailMessage)
            ->subject('New Lead Assigned - OkhlaFlat')
            ->greeting("Hello {$notifiable->name},")
            ->line('You have been assigned a new customer visit request.')
            ->line("Customer: **{$customer->name}**")
            ->line("Customer Mobile: **{$customer->mobile}**")
            ->line("Property: **{$propertyTitle}**")
            ->line($this->visitRequest->customer_notes ? "Customer Notes: \"{$this->visitRequest->customer_notes}\"" : '')
            ->action('View My Assigned Leads', route('agent.visits.index'))
            ->line('Please call the customer as soon as possible to schedule the office visit.');
    }
}
