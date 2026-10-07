<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\Balance;

class BalanceDTO
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?float $balance = null,
        public readonly ?string $currency = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?float $balanceRub = null,
        public readonly ?float $balanceUz = null,
    ) {}
}
