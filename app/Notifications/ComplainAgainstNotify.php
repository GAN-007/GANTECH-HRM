<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComplainAgainstNotify extends Notification
{
    use Queueable;
    public $complaint_title;
    public $complaint_form;

	/**
	 * Create a new notification instance.
	 *
	 * @param $complaint_form
	 * @param $complaint_title
	 */
    public function __construct($complaint_form,$complaint_title)
    {
        //
		$this->complaint_form = $complaint_form;
		$this->complaint_title = $complaint_title;
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
            //
			'data'=>$this->complaint_title.__('--A complaint has been filed against you by ') .$this->complaint_form ,
			'link' => 'ex/profile#Employee_Complaint',
        ];
    }
}
