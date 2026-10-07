<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\MarkPaid;

use App\Integrations\Enums\RequestMethod;
use App\Integrations\Payments\Bova\DTOs\BovaRequestDTO;

class MarkPaidRequestDTO extends BovaRequestDTO
{
    public function __construct(
        public readonly string $id,
    ) {}

    public function getMethod(): RequestMethod
    {
        return RequestMethod::PUT;
    }

    public function getEndpoint(): string
    {
        return '/p2p_transactions/' . $this->id . '/paid';
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
