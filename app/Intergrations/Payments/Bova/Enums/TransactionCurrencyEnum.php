<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\Enums;

enum TransactionCurrencyEnum: string
{
    case CRYPTO = 'crypto';
    case RUB = 'rub';
    case UZS = 'uzs';
    case KRW = 'krw';
    case KGS = 'kgs';
    case TJS = 'tjs';
    case AZN = 'azn';
}
