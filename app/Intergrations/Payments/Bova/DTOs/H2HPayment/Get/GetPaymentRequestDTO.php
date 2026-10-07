<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\H2HPayment\Get;

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
        return '/p2p_transactions/' . $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
