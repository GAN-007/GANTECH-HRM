<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeResignationNotify extends Notification
{
    use Queueable;
    public $resignation_date;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($resignation_date)
    {
        //
		$this->resignation_date = $resignation_date;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
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
			->subject('Resignation Request Acceptance')
			->line('The request for your resignation has been accepted. It will be applicable from '.$this->resignation_date)
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
			'data' => __('Your resignation request has been accepted'),
			'link' => '',
        ];
    }
}
