<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs;

use App\Integrations\Payments\Bova\Enums\SourceTransactionPaymentMethodEnum;
use App\Integrations\Payments\Bova\Enums\StateEnum;
use App\Integrations\Payments\Bova\Enums\TransactionCurrencyEnum;

class SourceTransactionPaymentDTO
{
    public function __construct(
        public readonly ?string $uuid = null,
        public readonly ?string $merchantId = null,
        public readonly ?string $formUrl = null,
        public readonly ?StateEnum $state = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?string $closeAt = null,
        public readonly ?TransactionCurrencyEnum $currency = null,
        public readonly ?string $callbackUrl = null,
        public readonly ?string $redirectUrl = null,
        public readonly ?float $amount = null,
        public readonly ?float $fiatAmount = null,
        public readonly ?string $selectedCryptoCurrency = null,
        public readonly ?SourceTransactionPaymentMethodEnum $sourceTransactionClass = null,
        public readonly ?SourceTransactionDTO $sourceTransaction = null,
    ) {}

    public static function fromResponse(array $data): self
    {
        return new self(
            uuid: $data['uuid'] ?? null,
            merchantId: $data['merchant_id'] ?? null,
            formUrl: $data['form_url'] ?? null,
            state: $data['state'] ? StateEnum::from($data['state']) : null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
            closeAt: $data['close_at'] ?? null,
            currency: $data['currency'] ? TransactionCurrencyEnum::from($data['currency']) : null,
            callbackUrl: $data['callback_url'] ?? null,
            redirectUrl: $data['redirect_url'] ?? null,
            amount: isset($data['amount']) ? (float) $data['amount'] : null,
            fiatAmount: isset($response['fiat_amount']) ? (float) $response['fiat_amount'] : null,
            selectedCryptoCurrency: $data['selected_crypto_currency'] ?? null,
            sourceTransactionClass: isset($data['source_transaction_class']) ?
                SourceTransactionPaymentMethodEnum::from($data['source_transaction_class']) : null,
            sourceTransaction: $data['source_transaction'] ?
                SourceTransactionDTO::fromResponse($data['source_transaction']) : null,
        );
    }
}
