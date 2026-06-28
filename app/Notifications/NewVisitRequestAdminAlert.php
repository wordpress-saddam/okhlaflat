<?php

namespace App\Notifications;

use App\Models\VisitRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewVisitRequestAdminAlert extends Notification implements ShouldQueue
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
        $propertyCode = $property ? " ({$property->property_code})" : '';

        return (new MailMessage)
            ->subject('New Visit Request Pending Assignment - OkhlaFlat')
            ->greeting('Hello Admin,')
            ->line('A new office visit request has been submitted and is pending agent assignment.')
            ->line("Customer: **{$customer->name}**")
            ->line("Customer Contact: **{$customer->mobile}**")
            ->line("Property: **{$propertyTitle}{$propertyCode}**")
            ->line($this->visitRequest->customer_notes ? "Notes: \"{$this->visitRequest->customer_notes}\"" : '')
            ->action('Assign Agent Now', route('admin.visits.index'))
            ->line('Please assign an agent to coordinate this request.');
    }
}
