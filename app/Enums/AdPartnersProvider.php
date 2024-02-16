<?php
namespace App\Enums;
 
enum AdPartnersProvider: string
{
    case Generic = 'generic';
    case CPALEAD = 'cpalead';
    case MYLEAD = 'mylead';
    case YANDEX = 'yandex';
 
    public function driver(): string
    {
        return match ($this) {
            self::Generic => 'generic',
            self::CPALEAD => 'cpalead',
            self::MYLEAD => 'mylead',
            self::YANDEX => 'yandex',
        };
    }
}