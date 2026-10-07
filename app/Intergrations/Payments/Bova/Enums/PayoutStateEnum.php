<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\Enums;

enum PayoutStateEnum: string
{
    case Created = 'created';
    case Processing = 'processing';
    case Paid = 'paid';
    case Failed = 'failed';
}
