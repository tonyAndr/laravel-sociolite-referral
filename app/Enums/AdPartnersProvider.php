<?php
namespace App\Enums;
 
enum AdPartnersProvider: string
{
    case Generic = 'generic';
    case Second = 'second';
 
    public function driver(): string
    {
        return match ($this) {
            self::Generic => 'generic',
            self::Second => 'second',
        };
    }
}