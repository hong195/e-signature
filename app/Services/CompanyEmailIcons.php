<?php


namespace App\Services;




class CompanyEmailIcons
{
    public function getIcons(int $companyId): array
    {
        if (!file_exists(asset('img/emailIcons/' . $companyId))) {
            return $this->getDefaultIcons();
        }

        return [
            'phone' => asset('img/emailIcons/' .$companyId. '/phone.png'),
            'map' =>  asset('img/emailIcons/' .$companyId. '/map.png'),
            'telegram' =>  asset('img/emailIcons/' .$companyId. '/telegram.png'),
            'web' =>  asset('img/emailIcons/' .$companyId. '/web.png'),
            'mail' =>  asset('img/emailIcons/' .$companyId. '/mail.png'),
        ];
    }

    public function getDefaultIcons(): array
    {
        return [
            'phone' => asset('img/emailIcons/default/phone.png'),
            'map' =>  asset('img/emailIcons/default/map.png'),
            'telegram' =>  asset('img/emailIcons/default/telegram.png'),
            'web' =>  asset('img/emailIcons/default/web.png'),
            'mail' =>  asset('img/emailIcons/default/mail.png'),
        ];
    }
}
