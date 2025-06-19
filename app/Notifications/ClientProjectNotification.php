<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientProjectNotification extends Notification {

	use Queueable;
	public $project;
	public $status;

	/**
	 * Create a new notification instance.
	 *
	 * @param $project
	 * @param $status
	 */
	public function __construct($project, $status)
	{
		$this->project = $project;
		$this->status = $status;
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
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 * @return MailMessage
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
	 * @param mixed $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
		if ($this->status == 'created')
		{
			return [
				'data' => __('A project has been created namely ') . $this->project->title . __(' by a client named ') . $this->project->client->name ,
				'link' => route('clientProject'),
			];
		} else
		{
			return [
				'data' => $this->project->title . __(' has been updated by a client named ') . $this->project->client->name ,
				'link' => route('clientProject'),
			];
		}
	}
}
