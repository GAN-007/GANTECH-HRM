<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfficialDocumentExpiry extends Notification implements ShouldQueue
{
    use Queueable;
	private $document_title;
	private $expiry_date;
	private $is_notify;

	/**
	 * Create a new notification instance.
	 *
	 * @param $doc_title
	 * @param $expiry_date
	 * @param $doc_type
	 */
	public function __construct($doc_title,$expiry_date,$is_notify)
	{
		//
		$this->document_title = $doc_title;
		$this->expiry_date = $expiry_date;
		$this->is_notify = $is_notify;
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
			->line('The document naming '.$this->document_title.' is going to be expired on '.$this->is_notify.' days from now ('.$this->expiry_date.')')
			->line('Please update your document.')
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
        // return [
        //     'data'=> 'A new notification about official document expiry',
        //     'link' => route('official_documents.index'),
        // ];
    }
}
