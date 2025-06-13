<?php

declare(strict_types=1);

namespace App\Entity\Enum;

enum Status: string
{
    case NEW = 'new';
    case PROCESSING = 'processing';
    case ON_DELIVERY = 'on-delivery';
    case COMPLETED = 'completed';
}
