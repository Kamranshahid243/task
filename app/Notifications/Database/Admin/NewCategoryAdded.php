<?php

namespace App\Notifications\Database\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCategoryAdded extends Notification
{
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
    public function __construct( $category, $superadmin, $nofityType, $type = 'category' )
    {

        $this->description  = '<div>';
        $this->description .= '<p><span>Name: </span><span>'.$category->name.'</span></p>';
        $this->description .= '<p><span>Description: </span><span>'.$category->description.'</span></p>';
       
 
        if( $nofityType == 'self-notify' ){
           
            $this->message          = 'You added new '.$type;
            $this->icon             = 'fa fa-square text-purple';
            $this->timelineIcon     = 'fa fa-square bg-purple';
           
        }
        else{
            $this->message          = '<a href="/admin/users/management/'.$superadmin->id.'">'.$superadmin->first_name.' '.$superadmin->last_name.'</a> added new '.$type;
            $this->icon             = 'fa fa-square text-purple';
            $this->timelineIcon     = 'fa fa-square bg-purple';
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
