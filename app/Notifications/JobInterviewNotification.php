<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobInterviewNotification extends Notification implements ShouldQueue
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
			->greeting('Congratulations!')
			->subject('Call For Interview')
			->line('Dear Mr/Mrs')
			->line('You have been shortlisted for the position of '.$this->interview->InterviewJob->job_title. ' hence,you are requested to attend our interview session in the following schedule and place. ')
			->line('Date and Time : '. $this->interview->interview_date. '|'.$this->interview->interview_time)
			->line('Venue : '. $this->interview->interview_place)
			->line($this->interview->description)
			->line('Thank you');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
//    public function toArray($notifiable)
//    {
//        return [
//            //
//        ];
//    }
}
