<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\Enums;

enum CommissionTypeEnum: string
{
    case Relative = 'relative';
    case Fixed = 'fixed';
}
