<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\Dispute;

class CreateDisputeResponseDTO
{
    public function __construct(
        public readonly bool $isSuccess,
        public readonly ?int $id = null,
        public readonly ?string $state = null,
        public readonly ?bool $repeated = null,
        public readonly ?string $updatedAt = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $proofImage = null,
        public readonly ?string $proofImage2 = null,
        public readonly ?float $amount = null,
        public readonly ?P2PTransactionDTO $p2pTx = null,
    ) {}

    public static function fromResponse(array $response): self
    {
        $data = $response['data'];

        return new self(
            isSuccess: ($response['status'] ?? null) === 'ok',
            id: $data['id'] ?? null,
            state: $data['state'] ?? null,
            repeated: $data['repeated'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
            createdAt: $data['created_at'] ?? null,
            proofImage: $data['proof_image'] ?? null,
            proofImage2: $data['proof_image2'] ?? null,
            amount: isset($data['amount']) ? (float) $data['amount'] : null,
            p2pTx: isset($data['p2p_tx']) ? new P2PTransactionDTO($data['p2p_tx']) : null,
        );
    }
}
