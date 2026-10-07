<?php

declare(strict_types=1);

namespace App\Http\Requests\Traits;

use App\Http\Requests\ApiFormRequest;
use App\Http\Requests\Enums\SortDirection;

/* @mixin ApiFormRequest */
trait WithSorting
{
    public function hasNotSortingKey(): bool
    {
        return empty($this->get('sorting', []));
    }

    public function hasSortingKey($key): bool
    {
        return collect($this->get('sorting', []))->where('key', $key)->isNotEmpty();
    }

    public function getSortDirection($key, SortDirection $defaultDirection = SortDirection::Asc): ?SortDirection
    {
        $sortingPair = collect($this->get('sorting', []))->where('key', $key)->first();

        return isset($sortingPair['direction'])
            ? SortDirection::from($sortingPair['direction'])
            : $defaultDirection;
    }
}
