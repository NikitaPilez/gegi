<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\Balance;

use App\Integrations\Enums\RequestMethod;
use App\Integrations\Payments\Bova\DTOs\BovaRequestDTO;

class GetBalancesRequestDTO extends BovaRequestDTO
{
    public function getMethod(): RequestMethod
    {
        return RequestMethod::GET;
    }

    public function getEndpoint(): string
    {
        return '/merchant/accounts';
    }

    public function toArray(): array
    {
        return [];
    }

    public function shouldBearerAuth(): bool
    {
        return true;
    }
}
