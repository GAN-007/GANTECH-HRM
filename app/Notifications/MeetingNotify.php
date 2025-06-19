<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MeetingNotify extends Notification {

	use Queueable;
	public $meeting;

	/**
	 * Create a new notification instance.
	 *
	 * @param $meeting
	 */
	public function __construct($meeting)
	{
		//
		$this->meeting = $meeting;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return ['database'];
	}


	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		if ($this->meeting->status == 'pending')
		{
			return [
				'data' => __('A meeting has been called: title: ') . $this->meeting->meeting_title . __(' on ') . $this->meeting->meeting_date . __(' at ') . $this->meeting->meeting_time,
				'link' => '',
			];
		} else
		{
			return [
				'data' => __('A meeting has been called: title: ') . $this->meeting->meeting_title . __(' on ') . $this->meeting->meeting_date . __(' at ') . $this->meeting->meeting_time . __(' is postponed'),
				'link' => '',
			];
		}
	}
}
