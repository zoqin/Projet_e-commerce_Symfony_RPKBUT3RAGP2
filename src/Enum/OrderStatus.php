<?php

namespace App\Enum;

enum OrderStatus: string {
    case PREPARATION = 'en préparation';
    case EXPEDIEE = 'expédiée';
    case LIVREE = 'livrée';
    case ANNULEE = 'annulée';
}