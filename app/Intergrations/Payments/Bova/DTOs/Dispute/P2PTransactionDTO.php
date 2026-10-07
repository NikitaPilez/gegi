<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\Dispute;

use App\Integrations\Payments\Bova\Enums\PaymentMethodEnum;
use App\Integrations\Payments\Bova\Enums\PayoutStateEnum;
use App\Integrations\Payments\Bova\Enums\TransactionCurrencyEnum;

class P2PTransactionDTO
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $merchantId = null,
        public readonly ?TransactionCurrencyEnum $currency = null,
        public readonly ?TransactionCurrencyEnum $toCurrency = null,
        public readonly ?PayoutStateEnum $state = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?string $closeAt = null,
        public readonly ?string $redirectUrl = null,
        public readonly ?string $email = null,
        public readonly ?string $customerName = null,
        public readonly ?float $rate = null,
        public readonly ?float $amount = null,
        public readonly ?float $fiatAmount = null,
        public readonly ?float $oldFiatAmount = null,
        public readonly ?PaymentMethodEnum $paymentMethod = null,
        public readonly ?string $payerBankName = null,
        public readonly ?string $comment = null,
        public readonly ?bool $antiFraudVerdict = null,
        public readonly ?P2PTransactionDetailDTO $detail = null,
    ) {}

    public static function fromResponse(array $p2pTx): self
    {
        return new self(
            id: $p2pTx['id'] ?? null,
            merchantId: $p2pTx['merchant_id'] ?? null,
            currency: isset($p2pTx['currency']) ?
                TransactionCurrencyEnum::from($p2pTx['currency']) : null,
            toCurrency: isset($p2pTx['to_currency']) ?
                TransactionCurrencyEnum::from($p2pTx['to_currency']) : null,
            state: isset($p2pTx['state']) ?
                PayoutStateEnum::from($p2pTx['state']) : null,
            createdAt: $p2pTx['created_at'] ?? null,
            updatedAt: $p2pTx['updated_at'] ?? null,
            closeAt: $p2pTx['close_at'] ?? null,
            redirectUrl: $p2pTx['redirect_url'] ?? null,
            email: $p2pTx['email'] ?? null,
            customerName: $p2pTx['customer_name'] ?? null,
            amount: isset($p2pTx['amount']) ? (float) $p2pTx['amount'] : null,
            fiatAmount: isset($p2pTx['fiat_amount']) ? (float) $p2pTx['fiat_amount'] : null,
            oldFiatAmount: isset($p2pTx['old_fiat_amount']) ? (float) $p2pTx['old_fiat_amount'] : null,
            paymentMethod: isset($p2pTx['payment_method']) ?
                PaymentMethodEnum::from($p2pTx['payment_method']) : null,
            payerBankName: $p2pTx['payer_bank_name'] ?? null,
            comment: $p2pTx['comment'] ?? null,
            antiFraudVerdict: $p2pTx['antifraud_verdict'] ?? null,
            detail: isset($p2pTx['requisities']) ? P2PTransactionDetailDTO::fromResponse($p2pTx['requisities']) : null,
        );
    }
}
