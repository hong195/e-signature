<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\CompanySetting;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\UserSignature;
use App\Notifications\WelcomeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class GenerateUserSignatureJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;
    /**
     * @var CompanySetting
     */
    private $settings;
    /**
     * @var Company
     */
    private $company;

    private $companyLogoUrl;

    private $avatar;

    /**
     * @var string
     */
    private $mainColor;
    private $companyContacts;
    private $userContacts;

    public function __construct(User $user, Company $company)
    {
        $this->user = $user;
        $this->company = $company;
        $this->companyLogoUrl = $company->getFirstMediaUrl('logo');
        $this->avatar = $user->getFirstMediaUrl('avatar');
        $this->mainColor = $company->settings()->where('name', 'color')->first()->value ?? '#7bba38';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Notification::route('mail', $this->user->email)
            ->notify(new UserSignature($this->user, $this->company, $this->mainColor, $this->avatar, $this->companyLogoUrl));
    }
}
