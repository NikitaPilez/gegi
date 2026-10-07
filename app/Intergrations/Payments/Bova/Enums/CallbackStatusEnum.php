<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\Enums;

enum CallbackStatusEnum: string
{
    case Success = 'successed';
    case AcceptedSuccess = 'accepted_successed';
    case RepeatedAcceptedSuccess = 'repeated_accepted_successed';
    case Failed = 'failed';
    case ClosedFailed = 'closed_failed';
    case RepeatedClosedFailed = 'repeated_closed_failed';
}
