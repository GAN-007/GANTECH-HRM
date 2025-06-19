<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeLeaveNotification extends Notification
{
    use Queueable;
    private $employee_name;
    private $total_days;
    private $start_date;
    private $end_date;
    private $leave_reason;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($employee_name,$total_days,$start_date,$end_date,$leave_reason)
    {
        $this->employee_name = $employee_name;
        $this->total_days    = $total_days;
        $this->start_date    = $start_date;
        $this->end_date      = $end_date;
        $this->leave_reason  = $leave_reason;

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
                    ->subject('Employee Leave Notification')
                    ->line($this->employee_name.' takes '.$this->total_days.' days leave from '.$this->start_date.' to '.$this->end_date.' due to '.$this->leave_reason)
                    ->action('Please Check', url('/timesheet/leaves'))
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
        ];
    }
}
