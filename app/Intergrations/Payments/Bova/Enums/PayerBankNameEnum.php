<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\Enums;

enum PayerBankNameEnum: string
{
    case Sberbank = 'sberbank';
    case Tinkoff = 'tinkoff';
    case Alafabank = 'alfabank';
    case VTB = 'vtb';
}
