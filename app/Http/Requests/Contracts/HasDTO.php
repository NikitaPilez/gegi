<?php

declare(strict_types=1);

namespace App\Http\Requests\Contracts;

interface HasDTO
{
    public function getDTO(): AbstractDTO;
}
