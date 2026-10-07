<?php

declare(strict_types=1);

namespace App\Integrations\DTOs;

abstract class ResponseDTO
{
    abstract public static function fromResponse(array $response): static;
}
