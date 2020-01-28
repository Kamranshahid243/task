<?php

namespace App\Notifications\Database\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPricingAdded extends Notification
{
    use Queueable;
    private $pricings;
    private $message;
    private $icon;
    private $timelineIcon;
    private $description;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $type, $pricings, $superadmin, $nofityType )
    {

        $this->description = '<div class="auc-notification-pricing-wrapper"';

        foreach( $pricings as $pricing ){
            $this->description .= '<p><span>'.$pricing->name.':</span> <span>$'.$pricing->price.'</span></p>';
        }

        $this->description .= '</div>';

        if( $nofityType == 'self-notify' ){
           
            $this->message          = 'You added '. count( $pricings ) .' new '.$type.' pricings';
            $this->icon             = 'fa fa-dollar text-yellow';
            $this->timelineIcon     = 'fa fa-dollar bg-yellow';
           
        }
        else{
            $this->message          = '<a href="/admin/users/management/'.$superadmin->id.'">'.$superadmin->first_name.' '.$superadmin->last_name.'</a> added '.count( $pricings ).' new '.$type.' pricings';
            $this->icon             = 'fa fa-dollar text-yellow';
            $this->timelineIcon     = 'fa fa-dollar bg-yellow';
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
