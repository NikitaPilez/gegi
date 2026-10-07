<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\Dispute;

use App\Integrations\Payments\Bova\Enums\PaymentMethodEnum;

class P2PTransactionDetailDTO
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $number = null,
        public readonly ?string $cardHolder = null,
        public readonly ?string $bankName = null,
        public readonly ?string $bankFullName = null,
        public readonly ?string $bankColors = null,
        public readonly ?string $brand = null,
        public readonly ?PaymentMethodEnum $paymentMethod = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?string $sberPayUrl = null,
    ) {}

    public static function fromResponse(array $detail): self
    {
        return new self(
            id: $detail['id'] ?? null,
            number: $detail['number'] ?? null,
            cardHolder: $detail['card_holder'] ?? null,
            bankName: $detail['bank_name'] ?? null,
            bankFullName: $detail['bank_full_name'] ?? null,
            bankColors: $detail['bank_colors'] ?? null,
            brand: $detail['brand'] ?? null,
            paymentMethod: $detail['payment_method'] ?
                PaymentMethodEnum::from($detail['payment_method']) : null,
            createdAt: $detail['created_at'] ?? null,
            updatedAt: $detail['updated_at'] ?? null,
            sberPayUrl: $detail['sberpay_url'] ?? null,
        );
    }
}
