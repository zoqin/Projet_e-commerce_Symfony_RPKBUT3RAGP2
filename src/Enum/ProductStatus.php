<?php

namespace App\Enum;

enum ProductStatus: string {
    case DISPONIBLE = 'disponible';
    case RUPTURE = 'en rupture';
    case PRECOMMANDE = 'en précommande';

    public function getBootstrapColor(): string
    {
        return match ($this) {
            self::DISPONIBLE => 'success',
            self::RUPTURE => 'danger',
            self::PRECOMMANDE => 'warning',
        };
    }
}

