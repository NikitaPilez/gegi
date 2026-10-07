<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\CreatePayout;

use App\Integrations\Payments\Bova\Enums\CommissionTypeEnum;
use App\Integrations\Payments\Bova\Enums\PaymentMethodEnum;
use App\Integrations\Payments\Bova\Enums\PayoutStateEnum;
use App\Integrations\Payments\Bova\Enums\TransactionCurrencyEnum;

class CreatePayoutResponseDTO
{
    public function __construct(
        public readonly bool $isSuccess,
        public readonly ?string $id = null,
        public readonly ?float $amount = null,
        public readonly ?CommissionTypeEnum $commissionType = null,
        public readonly ?float $rate = null,
        public readonly ?float $fiatAmount = null,
        public readonly ?float $oldFiatAmount = null,
        public readonly ?PayoutStateEnum $state = null,
        public readonly ?TransactionCurrencyEnum $currency = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?float $totalAmount = null,
        public readonly ?int $accountId = null,
        public readonly ?string $bankName = null,
        public readonly ?string $sbpBankName = null,
        public readonly ?PaymentMethodEnum $paymentMethod = null,
        public readonly ?string $recipientCard = null,
    ) {}

    public static function fromResponse(array $response): self
    {
        $data = $response['payload'] ?? null;

        return new self(
            isSuccess: ($response['result_code'] ?? null) === 'ok',
            id: $data['id'] ?? null,
            amount: isset($data['amount']) ? (float) $data['amount'] : null,
            commissionType: $data['commission_type'] ? CommissionTypeEnum::from($data['commission_type']) : null,
            rate: $data['rate'] ?? null,
            fiatAmount: isset($response['fiat_amount']) ? (float) $response['fiat_amount'] : null,
            oldFiatAmount: isset($response['old_fiat_amount']) ? (float) $response['old_fiat_amount'] : null,
            state: $data['state'] ? PayoutStateEnum::from($data['state']) : null,
            currency: $data['currency'] ? TransactionCurrencyEnum::from($data['currency']) : null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
            totalAmount: isset($data['total_amount']) ? (float) $data['total_amount'] : null,
            accountId: isset($data['account_id']) ? (int) $data['account_id'] : null,
            bankName: $detail['bank_name'] ?? null,
            sbpBankName: $detail['sbp_bank_name'] ?? null,
            paymentMethod: $data['payment_method'] ?
                PaymentMethodEnum::from($data['payment_method']) : null,
            recipientCard: $detail['recipient_card'] ?? null,
        );
    }
}
