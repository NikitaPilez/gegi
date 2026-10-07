<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\Balance;

class GetBalancesResponseDTO
{
    public function __construct(
        public readonly bool $isSuccess,
        public readonly ?array $balances = null,
    ) {}

    public static function fromResponse(array $response): self
    {
        return new self(
            isSuccess: ($response['result_code'] ?? null) === 'ok',
            balances: array_map(
                fn ($balance) => new BalanceDTO(
                    name: $balance['name'] ?? null,
                    balance: isset($balance['balance']) ? (float) $balance['balance'] : null,
                    currency: $balance['currency'] ?? null,
                    createdAt: $balance['created_at'] ?? null,
                    updatedAt: $balance['updated_at'] ?? null,
                    balanceRub: isset($balance['balance_rub']) ? (float) $balance['balance_rub'] : null,
                    balanceUz: isset($balance['balance_uzs']) ? (float) $balance['balance_uzs'] : null,
                ),
                $response['payload'] ?? []
            )
        );
    }
}
