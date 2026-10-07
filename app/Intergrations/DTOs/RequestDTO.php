<?php

declare(strict_types=1);

namespace App\Integrations\DTOs;

use App\Integrations\Enums\RequestMethod;

abstract class RequestDTO
{
    abstract public function getMethod(): RequestMethod;

    abstract public function getEndpoint(): string;

    abstract public function toArray(): array;
}
