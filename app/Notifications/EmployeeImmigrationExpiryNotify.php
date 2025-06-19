<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeImmigrationExpiryNotify extends Notification
{
    use Queueable;
    private $document_number;
	private $expiry_date;
	private $document_type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($document_number, $expiry_date, $document_type)
    {
        $this->document_number = $document_number;
		$this->expiry_date     = $expiry_date;
		$this->document_type   = $document_type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hello!')
			->subject('Document Expiring Reminder')
			->line('The document number '.$this->document_number.' ('
		    .$this->document_type.') is going to be expired from now ('.$this->expiry_date.')')
			->line('Please update the document.')
			->line('Thank you');
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
            //
        ];
    }
}
