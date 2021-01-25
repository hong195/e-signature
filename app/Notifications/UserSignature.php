<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserSignature extends Notification
{
    use Queueable;

    /**
     * @var User
     */
    private $user;
    /**
     * @var string
     */
    private $avatarUrl;
    /**
     * @var string
     */
    private $companyLogoUrl;
    /**
     * @var array
     */
    private $companySettings;
    /**
     * @var array
     */
    private $companyContacts;

//    public function __construct(User $user,
//                                string $avatarUrl,
//                                string $companyLogoUrl,
//                                array $companySettings,
//                                array $companyContacts)
//    {
//        $this->user = $user;
//        $this->avatarUrl = $avatarUrl;
//        $this->companyLogoUrl = $companyLogoUrl;
//        $this->companySettings = $companySettings;
//        $this->companyContacts = $companyContacts;
//    }
    public function __construct(User $user, string $mainColor, string $avatarUrl = null, string $companyLogoUrl = null)
    {
        $this->user = $user;
        $this->avatarUrl = $avatarUrl;
        $this->companyLogoUrl = $companyLogoUrl;
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
        $data = [
            'title' => 'Электронная подпись',
            'user' => $this->user,
            'avatarUrl' => $this->avatarUrl,
            'companySettings' => $this->companySettings,
            'companyContacts' => $this->companyContacts,
            'companyLogoUrl' => $this->companyLogoUrl
        ];

        return (new MailMessage)
            ->subject('Ваша электронная подпись')
            ->markdown('mails.user-signature', $data);
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
