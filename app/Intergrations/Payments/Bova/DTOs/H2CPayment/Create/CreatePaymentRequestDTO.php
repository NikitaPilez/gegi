<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\H2CPayment\Create;

use App\Integrations\Enums\RequestMethod;
use App\Integrations\Payments\Bova\DTOs\BovaRequestDTO;
use App\Integrations\Payments\Bova\Enums\PayerBankNameEnum;
use App\Integrations\Payments\Bova\Enums\PayerTypeEnum;
use App\Integrations\Payments\Bova\Enums\PaymentMethodEnum;
use App\Integrations\Payments\Bova\Enums\TransactionCurrencyEnum;
use InvalidArgumentException;

class CreatePaymentRequestDTO extends BovaRequestDTO
{
    public function __construct(
        public readonly string $merchantId,
        public readonly string $payerIdentifier,
        public readonly string $payerIP,
        public readonly PayerTypeEnum $payerType,
        public readonly TransactionCurrencyEnum $currency,
        public readonly int $amount,
        public readonly string $callbackUrl,
        public readonly ?string $redirectUrl = null,
        public readonly ?string $email = null,
        public readonly ?string $customerName = null,
        public readonly ?PaymentMethodEnum $paymentMethod = null,
        public readonly ?PayerBankNameEnum $payerBankName = null,
    ) {
        if (! in_array(
            $this->currency,
            $this->getAvailableCurrencies()
        )) {
            throw new InvalidArgumentException('$currency is not a valid currency value');
        }

        if (! in_array(
            $this->paymentMethod,
            $this->getAvailablePaymentMethod($this->currency)
        )) {
            throw new InvalidArgumentException('$paymentMethod is not a valid payment method value');
        }
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function getEndpoint(): string
    {
        return '/deposits';
    }

    public function toArray(): array
    {
        return $this->arrayNullFilter([
            'user_uuid' => $this->userUUId(),
            'merchant_id' => $this->merchantId,
            'payeer_identifier' => $this->payerIdentifier,
            'payeer_ip' => $this->payerIP,
            'payeer_type' => $this->payerType->value,
            'currency' => $this->currency->value,
            'payment_method' => $this->paymentMethod->value,
            'payeer_bank_name' => $this->payerBankName->value,
            'amount' => $this->amount,
            'callback_url' => $this->callbackUrl,
            'redirect_url' => $this->redirectUrl,
            'email' => $this->email,
            'customer_name' => $this->customerName,
        ]);
    }

    public function shouldGenerateSignature(): bool
    {
        return true;
    }

    public function getAvailableCurrencies(): array
    {
        return [
            TransactionCurrencyEnum::CRYPTO,
            TransactionCurrencyEnum::RUB,
            TransactionCurrencyEnum::UZS,
            TransactionCurrencyEnum::KRW,
            TransactionCurrencyEnum::AZN,
            TransactionCurrencyEnum::KGS,
            TransactionCurrencyEnum::TJS,
        ];
    }

    public function getAvailablePaymentMethod(TransactionCurrencyEnum $currency): array
    {
        return match ($currency) {
            TransactionCurrencyEnum::CRYPTO => [
                PaymentMethodEnum::Crypto,
            ],
            TransactionCurrencyEnum::RUB => [
                PaymentMethodEnum::Card,
                PaymentMethodEnum::Sberpay,
                PaymentMethodEnum::SBP,
                PaymentMethodEnum::AccountNumber,
                PaymentMethodEnum::InternationalCard,
                PaymentMethodEnum::OneClick,
                PaymentMethodEnum::Matching,
            ],
            TransactionCurrencyEnum::UZS, TransactionCurrencyEnum::KGS => [
                PaymentMethodEnum::Card,
            ],
            TransactionCurrencyEnum::KRW => [
                PaymentMethodEnum::AccountNumber,
            ],
            TransactionCurrencyEnum::AZN => [
                PaymentMethodEnum::Card,
                PaymentMethodEnum::QRCode,
            ],
            default => []
        };
    }
}
