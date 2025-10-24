<?php

namespace App\Enum;

enum ProductStatus: string {
    case DISPONIBLE = 'disponible';
    case RUPTURE = 'en rupture';
    case PRECOMMANDE = 'en précommande';
}

