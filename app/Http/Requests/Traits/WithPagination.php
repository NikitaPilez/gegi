<?php

declare(strict_types=1);

namespace App\Http\Requests\Traits;

use App\Http\Requests\ApiFormRequest;

/* @mixin ApiFormRequest */
trait WithPagination
{
    public function getLimit(): int
    {
        return (int) $this->get('limit', 20);
    }

    public function getPage(): int
    {
        return (int) $this->get('page', 1);
    }
}
