<?php

namespace App\Notifications;

use App\Models\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketAssignedNotification extends Notification
{
    use Queueable;
	/**
	 * @var SupportTicket
	 */
	public $ticket;


	/**
	 * Create a new notification instance.
	 *
	 * @param SupportTicket $ticket
	 */
    public function __construct(SupportTicket $ticket)
    {
        $this->ticket= $ticket;
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
			'data'=>$this->ticket->assignedEmployees()->count() . __(' Employees has been assigned for ') .$this->ticket->employee->full_name .' ticket',
			'link'=> route('tickets.show',$this->ticket),
		];
    }
}
