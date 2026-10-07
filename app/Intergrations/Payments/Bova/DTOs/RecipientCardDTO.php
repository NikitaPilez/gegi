<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs;

use App\Integrations\Payments\Bova\Enums\PaymentMethodEnum;

class RecipientCardDTO
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $number = null,
        public readonly ?string $bankName = null,
        public readonly ?string $bankFullName = null,
        public readonly ?array $bankColors = null,
        public readonly ?string $brand = null,
        public readonly ?string $cardHolder = null,
        public readonly ?PaymentMethodEnum $paymentMethod = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?string $sberpayUrl = null,
    ) {}

    public static function fromResponse(array $recipientData): self
    {
        return new self(
            id: $recipientData['id'] ?? null,
            number: $recipientData['number'] ?? null,
            bankName: $recipientData['bank_name'] ?? null,
            bankFullName: $recipientData['bank_full_name'] ?? null,
            bankColors: $recipientData['bank_colors'] ?? null,
            brand: $recipientData['brand'] ?? null,
            cardHolder: $recipientData['card_holder'] ?? null,
            paymentMethod: $recipientData['payment_method'] ?
                PaymentMethodEnum::from($recipientData['payment_method']) : null,
            createdAt: $recipientData['created_at'] ?? null,
            updatedAt: $recipientData['updated_at'] ?? null,
            sberpayUrl: $recipientData['sberpay_url'] ?? null,
        );
    }
}
