<?php

declare(strict_types=1);


use App\Integrations\Payments\Bova\DTOs\Callback\WebhookCallbackDTO;
use App\Integrations\Payments\Bova\Enums\CallbackStatusEnum;
use App\Models\Payment\Deposit;
use App\Models\Payment\MerchantMethod;
use App\Services\V1\Integrations\Payment\Callbacks\AbstractCallbackService;
use App\Services\V1\Integrations\Payment\Exceptions\AlreadyCreditDepositException;
use App\Services\V1\Integrations\Payment\Exceptions\AlreadyExpiredDepositException;
use App\Services\V1\Payment\Enums\DepositStatus;
use App\Services\V1\Wallet\Enums\Currency;

class BovaCallbackService extends AbstractCallbackService
{
    /**
     * @throws AlreadyCreditDepositException
     * @throws AlreadyExpiredDepositException
     */
    public function process(WebhookCallbackDTO $dto): void
    {
        if ($dto->merchantId && $dto->oldFiatAmount && $dto->status && $dto->rate) {
            $deposit = $this->getDeposit($dto->merchantId);

            if ($deposit) {

                if ($this->isPaidDeposit($deposit)) {
                    throw new AlreadyCreditDepositException(message: 'Bova, already credit deposit');
                } elseif ($this->isExpiredDeposit($deposit)) {
                    throw new AlreadyExpiredDepositException(message: 'Bova, already expired deposit');
                }

                $rate = $dto->rate;

                /** @var MerchantMethod $merchantMethod */
                $merchantMethod = MerchantMethod::query()->find($deposit->merchantMethod['id']);

                $paymentCurrency = Currency::from($merchantMethod->method->wallet_currency_id);
                $merchantCurrency = Currency::USDT;

                $deposit->initial_amount = $this->setAmounts(
                    paymentCurrency: $paymentCurrency,
                    merchantCurrency: $merchantCurrency,
                    paymentAmountValue: $dto->oldFiatAmount,
                    merchantAmountValue: ($dto->oldFiatAmount / $rate)
                );

                $deposit->amount = $this->setAmounts(
                    paymentCurrency: $paymentCurrency,
                    merchantCurrency: $merchantCurrency,
                    paymentAmountValue: $dto->fiatAmount,
                    merchantAmountValue: ($dto->fiatAmount / $rate)
                );

                $deposit->approved_amount = $this->setAmounts(
                    paymentCurrency: $paymentCurrency,
                    merchantCurrency: $merchantCurrency,
                    paymentAmountValue: ($dto->amount * $rate),
                    merchantAmountValue: $dto->amount
                );

                $deposit->total_amount = $this->setAmounts(
                    paymentCurrency: $paymentCurrency,
                    merchantCurrency: $merchantCurrency,
                    paymentAmountValue: ($dto->totalAmount * $rate),
                    merchantAmountValue: $dto->totalAmount,
                );

                if ($this->isNewSuccessfulPayment($deposit, $dto->status->value)) {
                    $deposit->status = ($dto->status === CallbackStatusEnum::Success)
                        ? DepositStatus::AutoApproved
                        : DepositStatus::ManuallyApproved;

                    $deposit->save();

                    $this->sendWebhook($deposit, $paymentCurrency, $merchantCurrency, \App\Services\V1\Integrations\Payment\Callbacks\Bova\now());
                } elseif ($this->checkIsNewExpiredPayment($deposit, $dto->status->value)) {
                    $deposit->status = DepositStatus::Expired;
                    $deposit->save();

                    $this->sendWebhook($deposit, $paymentCurrency, $merchantCurrency);
                }
            }
        }
    }

    private function setAmounts(
        Currency $paymentCurrency,
        Currency $merchantCurrency,
        float $paymentAmountValue,
        float $merchantAmountValue,
    ): array {

        return [
            $paymentCurrency->value => $paymentCurrency->toMinorUnit($paymentAmountValue),
            $merchantCurrency->value => $merchantCurrency->toMinorUnit($merchantAmountValue),
        ];
    }

    public function isNewSuccessfulPayment(Deposit $deposit, ?string $callbackStatus = null): bool
    {
        return ! in_array($deposit->status, [
            DepositStatus::AutoApproved,
            DepositStatus::ManuallyApproved,
            DepositStatus::Duplicate,
        ]) && in_array($callbackStatus, [
            CallbackStatusEnum::Success->value,
            CallbackStatusEnum::AcceptedSuccess->value,
            CallbackStatusEnum::RepeatedAcceptedSuccess->value,
        ]);
    }

    public function checkIsNewExpiredPayment(Deposit $deposit, string $callbackStatus): bool
    {
        return ! in_array($deposit->status, [
            DepositStatus::AutoApproved,
            DepositStatus::ManuallyApproved,
            DepositStatus::Duplicate,
            DepositStatus::Expired,
        ]) && $callbackStatus === CallbackStatusEnum::Failed->value;
    }
}
