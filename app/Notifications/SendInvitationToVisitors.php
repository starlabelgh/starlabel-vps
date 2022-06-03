<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Twilio\Rest\Notify;

class SendInvitationToVisitors extends Notification implements ShouldQueue
{
    use Queueable;

    private $pre_register;

    /**
     * SendInvitationToVisitors constructor.
     * @param $pre_register
     */
    public function __construct($pre_register)
    {
        $this->pre_register = $pre_register;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $array = ['database'];
        if (setting('twilio_disabled') != 0 &&
            !blank(setting('twilio_from')) &&
            !blank(setting('twilio_auth_token')) &&
            !blank(setting('twilio_account_sid'))
        ) {
            array_push($array, TwilioChannel::class);
        }

        if (setting('notifications_email') != false &&
            !blank(setting('mail_host')) &&
            !blank(setting('mail_username')) &&
            !blank(setting('mail_password')) &&
            !blank(setting('mail_port')) &&
            !blank(setting('mail_from_name')) &&
            !blank(setting('mail_from_address'))
        ) {
            array_push($array, 'mail');
        }

        return $array;
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
            ->subject("You Have Been Invited in a new Visitor#")
            ->greeting('Hello!')
            ->line('You Have Been Invited in a new Visitor Register')
            ->line('Invited To')
            ->line($this->pre_register->employee->name)
            ->line(setting('invite_templates'))
            ->line('Visitor Name: '. $this->pre_register->visitor->name . ' Email: ' .$this->pre_register->visitor->email . ' phone: ' .$this->pre_register->visitor->phone)
            ->line('Thank you for using our application! '.setting('site_name'));
    }

    /**
     * @param $notifiable
     * @return \NotificationChannels\Twilio\TwilioMessage|TwilioSmsMessage
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content(setting('notify_templates') .'Invited in a new Visitor Register '.'Invited To '.$this->pre_register->employee->name. 'Visitor Name: '. $this->pre_register->visitor->name . ' Email: ' .$this->pre_register->visitor->email .' Phone: ' .$this->pre_register->visitor->phone . '<--------->'.'Thank you for using our application! '.setting('site_name'));
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
