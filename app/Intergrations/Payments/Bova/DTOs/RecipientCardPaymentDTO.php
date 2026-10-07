<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs;

use App\Integrations\Payments\Bova\Enums\PaymentMethodEnum;
use App\Integrations\Payments\Bova\Enums\StateEnum;
use App\Integrations\Payments\Bova\Enums\TransactionCurrencyEnum;

class RecipientCardPaymentDTO
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $merchantId = null,
        public readonly ?string $formUrl = null,
        public readonly ?StateEnum $state = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?string $closeAt = null,
        public readonly ?TransactionCurrencyEnum $currency = null,
        public readonly ?PaymentMethodEnum $paymentMethod = null,
        public readonly ?string $callbackUrl = null,
        public readonly ?string $redirectUrl = null,
        public readonly ?string $email = null,
        public readonly ?string $customerName = null,
        public readonly ?float $amount = null,
        public readonly ?float $fiatAmount = null,
        public readonly ?float $oldFiatAmount = null,
        public readonly ?float $rate = null,
        public readonly ?float $serviceCommission = null,
        public readonly ?float $totalAmount = null,
        public readonly ?RecipientCardDTO $recipientCard = null,
    ) {}

    public static function fromResponse(array $response): self
    {
        return new self(
            id: $response['id'] ?? null,
            merchantId: $response['merchant_id'] ?? null,
            formUrl: $response['form_url'] ?? null,
            state: $response['state'] ? StateEnum::from($response['state']) : null,
            createdAt: $response['created_at'] ?? null,
            updatedAt: $response['updated_at'] ?? null,
            closeAt: $response['close_at'] ?? null,
            currency: $response['currency'] ? TransactionCurrencyEnum::from($response['currency']) : null,
            paymentMethod: $response['payment_method'] ?
                PaymentMethodEnum::from($response['payment_method']) : null,
            callbackUrl: $response['callback_url'] ?? null,
            redirectUrl: $response['redirect_url'] ?? null,
            email: $response['email'] ?? null,
            customerName: $response['customer_name'] ?? null,
            amount: isset($response['amount']) ? (float) $response['amount'] : null,
            fiatAmount: isset($response['fiat_amount']) ? (float) $response['fiat_amount'] : null,
            oldFiatAmount: isset($response['old_fiat_amount']) ? (float) $response['old_fiat_amount'] : null,
            rate: isset($response['rate']) ? (float) $response['rate'] : null,
            serviceCommission: isset($response['service_commission']) ? (float) $response['service_commission'] : null,
            totalAmount: isset($response['total_amount']) ? (float) $response['total_amount'] : null,
            recipientCard: isset($response['resipient_card']) ?
                RecipientCardDTO::fromResponse($response['resipient_card']) : null,
        );
    }
}
