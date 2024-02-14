<?php
namespace App\Enums;
 
enum AdPartnersProvider: string
{
    case Generic = 'generic';
    case CPALEAD = 'cpalead';
 
    public function driver(): string
    {
        return match ($this) {
            self::Generic => 'generic',
            self::CPALEAD => 'cpalead',
        };
    }
}