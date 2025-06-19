<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InterviewHostNotification extends Notification
{
    use Queueable;
	public $interview;

	/**
	 * Create a new notification instance.
	 *
	 * @param $interview
	 */
	public function __construct($interview)
	{
		//
		$this->interview = $interview;
	}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');
//    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
			'data'=> 'You have been selected as an interview host'."\n".'Interview Title: '.$this->interview->InterviewJob->job_title
				."\n".'Interview Date & Time: '  .$this->interview->interview_date. '|'.$this->interview->interview_time
				."\n".'Please set a reminder.',
			'link'=> '',
        ];
    }
}
