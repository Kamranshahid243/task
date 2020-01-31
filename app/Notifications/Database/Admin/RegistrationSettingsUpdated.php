<?php

namespace App\Notifications\Database\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationSettingsUpdated extends Notification
{
    use Queueable;
    use Queueable;
    private $admin;
    private $message;
    private $icon;
    private $timelineIcon;
    private $description;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $field, $superadmin, $nofityType, $type )
    {
        $this->description  = '<div>';
        $this->description .= '<p><span>Field Name: </span><span>'.$field->name.'</span></p>';
        $this->description .= '<p><span>Status: </span><span>'.$field->is_disabled?"Disabled":"Enabled".'</span></p>';

        if( $nofityType == 'self-notify' ){

            $this->message          = 'You updated '.$type;
            $this->icon             = 'fa fa-file-text text-purple';
            $this->timelineIcon     = 'fa fa-file-text bg-purple';

        }
        else{
            $this->message          = '<a href="/admin/users/management/'.$superadmin->id.'">'.$superadmin->first_name.' '.$superadmin->last_name.'</a> updated '.$type;
            $this->icon             = 'fa fa-file-text text-purple';
            $this->timelineIcon     = 'fa fa-file-text bg-purple';
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
            'type' => 'simple-with-description',
            'creator_name' => '',
            'object_description' => $this->description,
            'object_name' => '',
            'object_uri' => '',
        ];
    }
}
