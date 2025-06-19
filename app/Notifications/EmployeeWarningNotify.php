<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeWarningNotify extends Notification
{
    use Queueable;
    public $warning_data;
    public $state;

	/**
	 * Create a new notification instance.
	 *
	 * @param $warning_data
	 */
    public function __construct($warning_data,$state)
    {
        //
		$this->warning_data = $warning_data;
		$this->state = $state;
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
    	if ($this->state=='store')
		{
			return [
				//
				'data' => __('You have been warned for ') . $this->warning_data['subject'] . ' '
					. __('Status') . '-- ' . $this->warning_data['status'],
				'link' => '/profile#Employee_warning',
			];
		}
    	else
		{
			return [
				//
				'data' => __('Your Warning Info has been updated '),
				'link' => '/profile#Employee_warning',
			];
		}
    }
}
