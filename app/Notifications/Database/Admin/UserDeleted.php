<?php

namespace App\Notifications\Database\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserDeleted extends Notification
{
    use Queueable;
    private $admin;
    private $message;
    private $icon;
    private $timelineIcon;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $admin, $superadmin, $nofityType )
    {

        if( $nofityType == 'self-notify' ){
           
            $this->message          = 'You deleted <a href="/admin/users/management/'.$admin->id.'">'.$admin->first_name.' '.$admin->last_name.'</a> account';
            $this->icon             = 'fa fa-users text-success';
            $this->timelineIcon     = 'fa fa-users bg-green';
           
        }
        else{
            $this->message          = '<a href="/admin/users/management/'.$superadmin->id.'">'.$superadmin->first_name.' '.$superadmin->last_name.'</a> deleted <a href="/admin/users/management/'.$admin->id.'">'.$admin->first_name.' '.$admin->last_name.'</a> account';
            $this->icon             = 'fa fa-users text-success';
            $this->timelineIcon     = 'fa fa-users bg-green';
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
            'type' => 'simple',
            'creator_name' => '',
            'object_description' => '',
            'object_name' => '',
            'object_uri' => '',
        ];
    }
}
