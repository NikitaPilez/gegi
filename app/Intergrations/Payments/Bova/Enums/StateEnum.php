<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\Enums;

enum StateEnum: string
{
    case WaitingPayment = 'waiting_payment';
    case Paid = 'paid';
    case Success = 'successed';
    case AcceptedSuccess = 'accepted_successed';
    case RepeatedAcceptedSuccess = 'repeated_accepted_successed';
    case Failed = 'failed';
    case ClosedFailed = 'closed_failed';
    case RepeatedClosedFailed = 'repeated_closed_failed';
    case Reviewing = 'reviewing';
    case RepeatedReviewing = 'repeated_reviewing';
    case Processing = 'processing';
}
