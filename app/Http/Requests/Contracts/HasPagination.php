<?php

declare(strict_types=1);

namespace App\Http\Requests\Contracts;

interface HasPagination
{
    public function getLimit(): int;

    public function getPage(): int;
}
