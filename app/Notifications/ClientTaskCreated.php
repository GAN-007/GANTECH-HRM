<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClientTaskCreated extends Notification
{
    use Queueable;
	public $task;
	public $status;

	/**
	 * Create a new notification instance.
	 *
	 * @param $task
	 * @param $status
	 */
    public function __construct($task, $status)
	{
		$this->task = $task;
		$this->status = $status;
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
		if ($this->status == 'created')
		{
			return [
				'data' => __('A task has been created of ') . $this->task->project->title . __(' by a client named ') . $this->task->addedBy->username ,
				'link' => route('clientTask'),
			];
		} else
		{
			return [
				'data' => $this->task->task_name . __(' has been updated by a client named ') . $this->task->addedBy->username ,
				'link' => route('clientTask'),
			];
		}
    }
}
