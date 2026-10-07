<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\CreatePayout;

use App\Integrations\Enums\RequestMethod;
use App\Integrations\Payments\Bova\DTOs\BovaRequestDTO;
use App\Integrations\Payments\Bova\Enums\PaymentMethodEnum;
use App\Integrations\Payments\Bova\Enums\TransactionCurrencyEnum;
use InvalidArgumentException;

class CreatePayoutRequestDTO extends BovaRequestDTO
{
    public function __construct(
        public readonly string $merchantId,
        public readonly TransactionCurrencyEnum $currency,
        public readonly int $amount,
        public readonly string $callbackUrl,
        public readonly PaymentMethodEnum $paymentMethod,
        public readonly string $toCard,
        public readonly ?string $sbpBankName = null,
        public readonly ?string $bankName = null,
        public readonly ?string $recipientFirstName = null,
        public readonly ?string $recipientLastName = null,
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
        return '/mass_transactions';
    }

    public function toArray(): array
    {
        return $this->arrayNullFilter([
            'user_uuid' => $this->userUUId(),
            'merchant_id' => $this->merchantId,
            'currency' => $this->currency->value,
            'payment_method' => $this->paymentMethod->value,
            'amount' => $this->amount,
            'callback_url' => $this->callbackUrl,
            'to_card' => $this->toCard,
            'sbp_bank_name' => $this->sbpBankName,
            'bank_name' => $this->bankName,
            'recipient_first_name' => $this->recipientFirstName,
            'recipient_last_name' => $this->recipientLastName,
        ]);
    }

    public function shouldGenerateSignature(): bool
    {
        return true;
    }

    public function getAvailableCurrencies(): array
    {
        return [
            TransactionCurrencyEnum::RUB,
            TransactionCurrencyEnum::UZS,
            TransactionCurrencyEnum::KRW,
            TransactionCurrencyEnum::AZN,
            TransactionCurrencyEnum::KGS,
        ];
    }

    public function getAvailablePaymentMethod(TransactionCurrencyEnum $currency): array
    {
        return match ($currency) {
            TransactionCurrencyEnum::RUB => [
                PaymentMethodEnum::Card,
                PaymentMethodEnum::CardFast,
                PaymentMethodEnum::SBP,
                PaymentMethodEnum::SbpFast,
                PaymentMethodEnum::AccountNumber,
            ],
            TransactionCurrencyEnum::UZS, TransactionCurrencyEnum::AZN, TransactionCurrencyEnum::KGS => [
                PaymentMethodEnum::Card,
            ],
            TransactionCurrencyEnum::KRW => [
                PaymentMethodEnum::AccountNumber,
            ],
            default => []
        };
    }
}
