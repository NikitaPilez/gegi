<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\H2CPayment\Get;

use App\Integrations\Enums\RequestMethod;
use App\Integrations\Payments\Bova\DTOs\BovaRequestDTO;

class GetPaymentRequestDTO extends BovaRequestDTO
{
    public function __construct(
        public readonly string $id,
    ) {}

    public function getMethod(): RequestMethod
    {
        return RequestMethod::GET;
    }

    public function getEndpoint(): string
    {
        return '/deposits/' . $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
