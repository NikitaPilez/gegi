<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\Enums;

enum PaymentMethodEnum: string
{
    case Crypto = 'crypto';
    case Card = 'card';
    case Sberpay = 'sberpay';
    case SBP = 'sbp';
    case AccountNumber = 'account_number';
    case InternationalCard = 'international_card';
    case OneClick = 'one_click';
    case Matching = 'matching';
    case QRCode = 'qrcode';
    case CardFast = 'card_fast';
    case SbpFast = 'sbp_fast';
}
