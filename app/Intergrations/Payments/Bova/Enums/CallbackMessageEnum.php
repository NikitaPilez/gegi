<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\Enums;

enum CallbackMessageEnum: string
{
    case DeclinedByTimeout = 'declined by timeout';
    case DeclinedByAntiFraud = 'declined by antifraud';
    case DeclinedByUser = 'declined by user';
    case PaymentNotFound = 'payment not found';
    case FakeProof = 'fake proof';
    case InvalidProofDatetime = 'invalid proof datetime';
    case InvalidProofRequisites = 'invalid proof requisites';
    case BankAccountBlocked = 'bank account blocked';
}
