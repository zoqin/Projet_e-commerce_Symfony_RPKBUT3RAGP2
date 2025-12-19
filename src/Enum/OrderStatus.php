<?php

namespace App\Enum;

enum OrderStatus: string {
    case PREPARATION = 'en préparation';
    case EXPEDIEE = 'expédiée';
    case LIVREE = 'livrée';
    case ANNULEE = 'annulée';

    public function getBootstrapColor(): string
    {
        return match ($this) {
            self::LIVREE => 'success',
            self::ANNULEE => 'danger',
            self::PREPARATION,
            self::EXPEDIEE => 'warning',
        };
    }
}