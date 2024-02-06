<?php
namespace App\Enums;
 
enum OAuthProvider: string
{
    case Telegram = 'telegram';
    case Yandex = 'yandex';
    case Vkontakte = 'vkontakte';
    case Tiktok = 'tiktok';
 
    public function driver(): string
    {
        return match ($this) {
            self::Telegram => 'telegram',
            self::Yandex => 'yandex',
            self::Vkontakte => 'vkontakte',
            self::Tiktok => 'tiktok',
        };
    }
}