<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\Enums;

enum SourceTransactionPaymentMethodEnum: string
{
    case P2P = 'P2pTransaction';
    case CryptoTransaction = 'CryptoTransaction';
}
