<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\Rate;

use App\Integrations\Enums\RequestMethod;
use App\Integrations\Payments\Bova\DTOs\BovaRequestDTO;

class GetRatesRequestDTO extends BovaRequestDTO
{
    public function getMethod(): RequestMethod
    {
        return RequestMethod::GET;
    }

    public function getEndpoint(): string
    {
        return '/merchant/rates';
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
