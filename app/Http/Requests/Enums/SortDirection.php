<?php

declare(strict_types=1);

namespace App\Http\Requests\Enums;

use ArchTech\Enums\Values;

enum SortDirection: string
{
    use Values;

    case Asc = 'asc';
    case Desc = 'desc';
}
