<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs;

use App\Integrations\Payments\Bova\Enums\PaymentMethodEnum;
use App\Integrations\Payments\Bova\Enums\StateEnum;
use App\Integrations\Payments\Bova\Enums\TransactionCurrencyEnum;

class SourceTransactionDTO
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $merchantId = null,
        public readonly ?TransactionCurrencyEnum $currency = null,
        public readonly ?StateEnum $state = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?string $closeAt = null,
        public readonly ?string $redirectUrl = null,
        public readonly ?string $email = null,
        public readonly ?string $customerName = null,
        public readonly ?float $rate = null,
        public readonly ?float $commission = null,
        public readonly ?float $amount = null,
        public readonly ?float $totalAmount = null,
        public readonly ?float $fiatAmount = null,
        public readonly ?float $oldFiatAmount = null,
        public readonly ?PaymentMethodEnum $paymentMethod = null,
        public readonly ?string $payerBankName = null,
    ) {}

    public static function fromResponse(array $sourceTransaction): self
    {
        return new self(
            id: $sourceTransaction['id'] ?? null,
            merchantId: $sourceTransaction['merchant_id'] ?? null,
            currency: $sourceTransaction['currency']
                ? TransactionCurrencyEnum::from($sourceTransaction['currency']) : null,
            state: $sourceTransaction['state'] ? StateEnum::from($sourceTransaction['state']) : null,
            createdAt: $sourceTransaction['created_at'] ?? null,
            updatedAt: $sourceTransaction['updated_at'] ?? null,
            closeAt: $sourceTransaction['close_at'] ?? null,
            redirectUrl: $sourceTransaction['redirect_url'] ?? null,
            email: $sourceTransaction['email'] ?? null,
            customerName: $sourceTransaction['customer_name'] ?? null,
            rate: isset($sourceTransaction['rate']) ? (float) $sourceTransaction['rate'] : null,
            commission: isset($sourceTransaction['service_commission']) ? (float) $sourceTransaction['service_commission'] : null,
            amount: isset($sourceTransaction['amount']) ? (float) $sourceTransaction['amount'] : null,
            totalAmount: isset($sourceTransaction['total_amount']) ? (float) $sourceTransaction['total_amount'] : null,
            fiatAmount: isset($sourceTransaction['fiat_amount']) ? (float) $sourceTransaction['fiat_amount'] : null,
            oldFiatAmount: isset($sourceTransaction['old_fiat_amount']) ? (float) $sourceTransaction['old_fiat_amount'] : null,
            paymentMethod: $sourceTransaction['payment_method'] ?
                PaymentMethodEnum::from($sourceTransaction['payment_method']) : null,
            payerBankName: $sourceTransaction['payeer_bank_name'] ?? null,
        );
    }
}
