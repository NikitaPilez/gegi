<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\Callback;

use App\Integrations\Payments\Bova\Enums\CallbackMessageEnum;
use App\Integrations\Payments\Bova\Enums\CallbackStatusEnum;
use App\Integrations\Payments\Bova\Enums\PaymentMethodEnum;

class WebhookCallbackDTO
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $merchantId = null,
        public readonly ?CallbackStatusEnum $status = null,
        public readonly ?CallbackMessageEnum $message = null,
        public readonly ?string $currency = null,
        public readonly ?PaymentMethodEnum $paymentMethod = null,
        public readonly ?float $rate = null,
        public readonly ?float $amount = null,
        public readonly ?float $fiatAmount = null,
        public readonly ?float $oldFiatAmount = null,
        public readonly ?float $commission = null,
        public readonly ?float $totalAmount = null,
        public readonly ?string $payerCardNumber = null,
        public readonly ?string $recipientCardNumber = null,
        public readonly ?string $recipientCardNumberType = null,
    ) {}
}
