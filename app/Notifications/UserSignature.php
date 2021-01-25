<?php

namespace App\Notifications;

use App\Models\Company;
use App\Models\User;
use App\Services\CompanyEmailIcons;
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
    /**
     * @var Company
     */
    private $company;
    /**
     * @var string
     */
    private $mainColor;
    /**
     * @var array
     */
    private $icons;

    public function __construct(User $user,
                                Company $company,
                                string $mainColor,
                                string $avatarUrl = null,
                                string $companyLogoUrl = null)
    {
        $this->user = $user;
        $this->avatarUrl = $avatarUrl;
        $this->companyLogoUrl = $companyLogoUrl;
        $this->company = $company;
        $this->mainColor = $mainColor;
        $this->icons = app()->make(CompanyEmailIcons::class)->getIcons($this->company->id);
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
            'company' => $this->company,
            'avatarUrl' => $this->avatarUrl,
            'companyLogoUrl' => $this->companyLogoUrl,
            'color' => $this->mainColor,
            'icons' => $this->icons
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
