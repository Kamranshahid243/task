<?php

namespace App\Notifications\Database\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewFaqAdded extends Notification
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
    public function __construct( $faq, $superadmin, $nofityType )
    {

        $this->description  = '<div>';
        $this->description .= '<h4>'.$faq->question.'</h4>';
        $this->description .= '<p>'.$faq->answer.'</p>';
        $this->description .= '</div>';
       
 
        if( $nofityType == 'self-notify' ){
           
            $this->message          = 'You added new faq';
            $this->icon             = 'fa fa-question-circle text-green';
            $this->timelineIcon     = 'fa fa-question-circle bg-green';
           
        }
        else{
            $this->message          = '<a href="/admin/users/management/'.$superadmin->id.'">'.$superadmin->first_name.' '.$superadmin->last_name.'</a> added new faq';
            $this->icon             = 'fa fa-question-circle text-green';
            $this->timelineIcon     = 'fa fa-question-circle bg-green';
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
