<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\MarkPaid;

use App\Integrations\Payments\Bova\DTOs\RecipientCardPaymentDTO;

class MarkPaidResponseDTO
{
    public function __construct(
        public readonly bool $isSuccess,
        public readonly ?RecipientCardPaymentDTO $paymentDTO = null,
    ) {}

    public static function fromResponse(array $response): self
    {
        return new self(
            isSuccess: ($response['result_code'] ?? null) === 'ok',
            paymentDTO: RecipientCardPaymentDTO::fromResponse($response),
        );
    }
}
