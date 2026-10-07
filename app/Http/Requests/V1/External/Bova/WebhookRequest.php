<?php

declare(strict_types=1);


use App\Http\Requests\BaseWebhookRequest;
use App\Integrations\Payments\Bova\BovaAPIService;
use App\Integrations\Payments\Bova\DTOs\Callback\WebhookCallbackDTO;
use App\Integrations\Payments\Bova\Enums\CallbackMessageEnum;
use App\Integrations\Payments\Bova\Enums\CallbackStatusEnum;
use App\Integrations\Payments\Bova\Enums\PaymentMethodEnum;
use Illuminate\Validation\Rule;

class WebhookRequest extends BaseWebhookRequest
{
    public function defaultRules(): array
    {
        return [
            'id' => [
                'nullable',
                'uuid',
            ],
            'merchant_id' => [
                'nullable',
                'uuid',
            ],
            'status' => [
                'nullable',
                Rule::enum(CallbackStatusEnum::class),
            ],
            'message' => [
                'nullable',
                Rule::enum(CallbackMessageEnum::class),
            ],
            'currency' => [
                'nullable',
                'string',
            ],
            'payment_method' => [
                'nullable',
                'string',
                Rule::enum(PaymentMethodEnum::class),
            ],
            'amount' => [
                'nullable',
                'numeric',
            ],
            'fiat_amount' => [
                'nullable',
                'numeric',
            ],
            'old_fiat_amount' => [
                'nullable',
                'numeric',
            ],
            'rate' => [
                'nullable',
                'numeric',
            ],
            'service_commission' => [
                'nullable',
                'numeric',
            ],
            'payeer_card_number' => [
                'nullable',
            ],
            'recipient_card_number' => [
                'nullable',
            ],
            'recipient_card_number_type' => [
                'nullable',
                'string',
                Rule::in(['card', 'phone_number']),
            ],
        ];
    }

    protected function checkSign(): bool
    {
        $signature = $this->header('Signature');

        return $signature === BovaAPIService::getSign(
            $this->all(),
            config('services.bova.api_key')
            );
    }

    protected function getIps(): array
    {
        return [];
    }

    public function getDto(): WebhookCallbackDTO
    {
        return new WebhookCallbackDTO(
            id: $this->input('id'),
            merchantId: $this->input('merchant_id'),
            status: $this->input('status')
                ? CallbackStatusEnum::from($this->input('status'))
                : null,
            message: $this->input('message')
                ? CallbackMessageEnum::from($this->input('message'))
                : null,
            currency: $this->input('currency'),
            paymentMethod: $this->input('payment_method')
                ? PaymentMethodEnum::from($this->input('payment_method'))
                : null,
            rate: $this->float('rate'),
            amount: $this->float('amount'),
            fiatAmount: $this->float('fiat_amount'),
            oldFiatAmount: $this->float('old_fiat_amount'),
            commission: $this->float('commission'),
            totalAmount: $this->float('total_amount'),
            payerCardNumber: $this->input('payeer_card_number'),
            recipientCardNumber: $this->input('recipient_card_number'),
            recipientCardNumberType: $this->input('recipient_card_number_type')
        );
    }
}
