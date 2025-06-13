<?php

declare(strict_types=1);

namespace App\Entity\Enum;

enum Currency: string
{
    case CZK = 'CZK';
    case USD = 'USD';
    case EUR = 'EUR';
}
