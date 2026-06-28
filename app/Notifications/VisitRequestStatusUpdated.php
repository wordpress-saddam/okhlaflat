<?php

namespace App\Notifications;

use App\Models\VisitRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VisitRequestStatusUpdated extends Notification implements ShouldQueue
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
        $status = ucfirst($this->visitRequest->status);

        $mailMessage = (new MailMessage)
            ->greeting("Hello {$notifiable->name},");

        if ($this->visitRequest->status === 'completed') {
            $mailMessage->subject('Visit Completed - OkhlaFlat')
                ->line("Your physical office visit for **{$propertyTitle}** has been marked as **Completed**.")
                ->line('We hope your experience was seamless. If you closed a deal, our office team will handle the documentation and onboarding processes with you.')
                ->line('If you have any feedback or further requirements, do not hesitate to contact us.');
        } else {
            $mailMessage->subject('Visit Cancelled - OkhlaFlat')
                ->line("Your physical office visit for **{$propertyTitle}** has been marked as **Cancelled**.")
                ->line('If this cancellation was unintended, or you would like to reschedule, please contact your agent or visit our website to request another appointment.');
        }

        return $mailMessage
            ->action('View My Dashboard', route('customer.dashboard'))
            ->line('Thank you for choosing OkhlaFlat!');
    }
}
