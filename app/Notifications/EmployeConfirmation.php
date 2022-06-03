<?php

namespace App\Notifications;

use App\Enums\VisitorStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class EmployeConfirmation extends Notification
{
    use Queueable;

    private $visitingDetails;
    private $token;

    /**
     * SendInvitationToVisitors constructor.
     * @param $visitingDetails
     */
    public function __construct($visitingDetails,$token)
    {
        $this->visitingDetails = $visitingDetails;
        $this->token = $token;
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
        if (
            setting('twilio_disabled') != 0 &&
            !blank(setting('twilio_from')) &&
            !blank(setting('twilio_auth_token')) &&
            !blank(setting('twilio_account_sid'))
        ) {
            array_push($array, TwilioChannel::class);
        }

        if (
            setting('notifications_email') != false &&
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
       
        $acceptedButtonUrl = url('visitor/change-status/'.VisitorStatus::ACCEPT.'/'.$this->token);
        $rejectButtonUrl   = url('visitor/change-status/'.VisitorStatus::REJECT.'/'.$this->token);
        $visitor           = array(
            'visitor_name'  => $this->visitingDetails->visitor->name,
            'visitor_phone' => $this->visitingDetails->visitor->phone,
            'visitor_email' => $this->visitingDetails->visitor->email,
            'name'          => $this->visitingDetails->employee->name,
            'email'         => $this->visitingDetails->employee->email,
            'phone'         => $this->visitingDetails->employee->phone,
            'status'        => $this->visitingDetails->status,
            'acceptedUrl'   => $acceptedButtonUrl,
            'rejectUrl'     => $rejectButtonUrl,
        );
       
        return (new MailMessage)
            ->subject("New Visitor#" .$this->visitingDetails->reg_no)
            ->markdown('admin.mail.visitor.employee', ['visitor'=>$visitor]);
    }

    /**
     * @param $notifiable
     * @return \NotificationChannels\Twilio\TwilioMessage|TwilioSmsMessage
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content(setting('notify_templates') . 'New Visitor Register' . 'Visitor Name: ' . $this->visitingDetails->visitor->name . ' Email: ' . $this->visitingDetails->visitor->email . ' Phone: ' . $this->visitingDetails->visitor->phone);
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
