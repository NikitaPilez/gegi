<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\Enums;

use ArchTech\Enums\Values;

enum PayerTypeEnum: string
{
    use Values;
    case FTD = 'ftd';
    case Trust = 'trust';
}
