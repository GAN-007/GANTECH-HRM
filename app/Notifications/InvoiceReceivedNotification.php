<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceReceivedNotification extends Notification
{
    use Queueable;
	public $invoice;

	/**
	 * Create a new notification instance.
	 *
	 * @param $invoice
	 */
	public function __construct($invoice)
	{
		//
		$this->invoice = $invoice;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['mail', 'database'];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return MailMessage
	 */
	public function toMail($notifiable)
	{
		return (new MailMessage)
			->greeting('Hello!')
			->subject('Invoice Received')
			->line('Dear ' . $this->invoice->client->name)
			->line('This is the invoice of the project : ' . $this->invoice->project->title .' which is due '.$this->invoice->invoice_due_date)
			->line('You are requested to pay the amount before the due date.')
			->action('Details', route('invoices.show', $this->invoice))
			->line('Thank you')
			->line('For any further query contact: '.$this->invoice->project->company->email. ' or Contact no: '.$this->invoice->project->company->contact_no);
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		return [
			'data'=>trans('Invoice of Project : '). $this->invoice->project->title.__(' has been received'),
			'link'=> route('invoices.show',$this->invoice),
		];
	}
}
