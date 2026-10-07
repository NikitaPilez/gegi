<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\GetPayout;

use App\Integrations\Payments\Bova\Enums\CommissionTypeEnum;
use App\Integrations\Payments\Bova\Enums\PaymentMethodEnum;
use App\Integrations\Payments\Bova\Enums\PayoutStateEnum;
use App\Integrations\Payments\Bova\Enums\TransactionCurrencyEnum;

class GetPayoutResponseDTO
{
    public function __construct(
        public readonly bool $isSuccess,
        public readonly ?string $id = null,
        public readonly ?string $merchantId = null,
        public readonly ?PayoutStateEnum $state = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        public readonly ?TransactionCurrencyEnum $currency = null,
        public readonly ?string $callbackUrl = null,
        public readonly ?float $amount = null,
        public readonly ?float $fiatAmount = null,
        public readonly ?float $oldFiatAmount = null,
        public readonly ?float $rate = null,
        public readonly ?CommissionTypeEnum $commissionType = null,
        public readonly ?float $serviceCommission = null,
        public readonly ?float $totalAmount = null,
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
            merchantId: $data['merchant_id'] ?? null,
            state: isset($data['state']) ? PayoutStateEnum::from($data['state']) : null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
            currency: isset($data['currency']) ? TransactionCurrencyEnum::from($data['currency']) : null,
            callbackUrl: $data['callback_url'] ?? null,
            amount: isset($data['amount']) ? (float) $data['amount'] : null,
            fiatAmount: isset($data['fiat_amount']) ? (float) $data['fiat_amount'] : null,
            oldFiatAmount: isset($data['old_fiat_amount']) ? (float) $data['old_fiat_amount'] : null,
            rate: isset($data['rate']) ? (float) $data['rate'] : null,
            commissionType: isset($data['commission_type']) ? CommissionTypeEnum::from($data['commission_type']) : null,
            serviceCommission: isset($data['service_commission']) ? (float) $data['service_commission'] : null,
            totalAmount: isset($data['total_amount']) ? (float) $data['total_amount'] : null,
            bankName: $data['bank_name'] ?? null,
            sbpBankName: $data['sbp_bank_name'] ?? null,
            paymentMethod: isset($data['payment_method']) ? PaymentMethodEnum::from($data['payment_method']) : null,
            recipientCard: $data['recipient_card'] ?? null,
        );
    }
}
