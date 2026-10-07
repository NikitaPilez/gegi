<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\Dispute;

use App\Integrations\Enums\RequestMethod;
use App\Integrations\Payments\Bova\DTOs\BovaRequestDTO;

class CreateDisputeRequestDTO extends BovaRequestDTO
{
    public function __construct(
        public readonly string $transactionId,
        public readonly int $amount,
        public readonly string $mainImage,
        public readonly ?string $secondImage = null,
    ) {}

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function getEndpoint(): string
    {
        return '/p2p_disputes/from_client';
    }

    public function toArray(): array
    {
        return $this->arrayNullFilter([
            'transaction_id' => $this->transactionId,
            'p2p_dispute' => [
                'amount' => $this->amount,
                'main_image' => $this->mainImage,
                'second_image' => $this->secondImage,
            ],
        ]);
    }

    public function shouldSendAsForm(): bool
    {
        return true;
    }
}
