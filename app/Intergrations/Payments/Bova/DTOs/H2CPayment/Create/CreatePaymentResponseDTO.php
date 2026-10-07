<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\H2CPayment\Create;

use App\Integrations\Payments\Bova\DTOs\SourceTransactionPaymentDTO;

class CreatePaymentResponseDTO
{
    public function __construct(
        public readonly bool $isSuccess,
        public readonly ?SourceTransactionPaymentDTO $paymentDTO = null,
    ) {}

    public static function fromResponse(array $response): self
    {
        return new self(
            isSuccess: ($response['status'] ?? null) === 'ok',
            paymentDTO: SourceTransactionPaymentDTO::fromResponse($response['data']),
        );
    }
}
