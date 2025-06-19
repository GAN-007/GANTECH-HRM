<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeDocumentExpiryNotifyToDeptartmentHead extends Notification
{
    use Queueable;
    private $document_title;
	private $expiry_date;
	private $document_type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($document_title, $expiry_date, $document_type)
    {
        $this->document_title = $document_title;
		$this->expiry_date    = $expiry_date;
		$this->document_type  = $document_type;
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
			->line('The document number '.$this->document_title.' ('
		    .$this->document_type.') is going to be expired on 3 days from now ('.$this->expiry_date.')')
			->line('Need to update the document.')
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
