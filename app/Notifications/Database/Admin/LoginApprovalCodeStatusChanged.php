<?php

namespace App\Notifications\Database\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginApprovalCodeStatusChanged extends Notification
{
    use Queueable;
    private $message;
    private $icon;
    private $timelineIcon;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $status )
    {
        if( $status == 'enable' ){
            $this->message          = 'You enabled login approval code';
            $this->icon             = 'fa fa-check text-success';
            $this->timelineIcon     = 'fa fa-check bg-green';
        }
        else{
            $this->message          = 'You disabled login approval code';
            $this->icon             = 'fa fa-times text-red';
            $this->timelineIcon     = 'fa fa-times bg-red';
        }
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'icon' => $this->icon,
            'timeline_icon' => $this->timelineIcon,
            'type' => 'simple-with-view-link',
            'creator_name' => '',
            'object_description' => '',
            'object_name' => '',
            'object_uri' => '/admin/security/settings',
        ];
    }
}
