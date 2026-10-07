<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova;

use App\Integrations\Api;
use App\Integrations\Payments\Bova\DTOs\Balance\GetBalancesRequestDTO;
use App\Integrations\Payments\Bova\DTOs\Balance\GetBalancesResponseDTO;
use App\Integrations\Payments\Bova\DTOs\BovaRequestDTO;
use App\Integrations\Payments\Bova\DTOs\Cancel\CancelRequestDTO;
use App\Integrations\Payments\Bova\DTOs\Cancel\CancelResponseDTO;
use App\Integrations\Payments\Bova\DTOs\CreatePayout\CreatePayoutRequestDTO;
use App\Integrations\Payments\Bova\DTOs\CreatePayout\CreatePayoutResponseDTO;
use App\Integrations\Payments\Bova\DTOs\Dispute\CreateDisputeRequestDTO;
use App\Integrations\Payments\Bova\DTOs\Dispute\CreateDisputeResponseDTO;
use App\Integrations\Payments\Bova\DTOs\GetPayout\GetPayoutRequestDTO;
use App\Integrations\Payments\Bova\DTOs\GetPayout\GetPayoutResponseDTO;
use App\Integrations\Payments\Bova\DTOs\H2CPayment\Create\CreatePaymentRequestDTO as H2CPaymentCreateRequestDTO;
use App\Integrations\Payments\Bova\DTOs\H2CPayment\Create\CreatePaymentResponseDTO as H2CPaymentCreateResponseDTO;
use App\Integrations\Payments\Bova\DTOs\H2CPayment\Get\GetPaymentRequestDTO as H2CGetPaymentRequestDTO;
use App\Integrations\Payments\Bova\DTOs\H2CPayment\Get\GetPaymentResponseDTO as H2CGetPaymentResponseDTO;
use App\Integrations\Payments\Bova\DTOs\H2HPayment\Create\CreatePaymentRequestDTO as H2HPaymentCreateRequestDTO;
use App\Integrations\Payments\Bova\DTOs\H2HPayment\Create\CreatePaymentResponseDTO as H2HPaymentCreateResponseDTO;
use App\Integrations\Payments\Bova\DTOs\H2HPayment\Get\GetPaymentRequestDTO as H2HGetPaymentRequestDTO;
use App\Integrations\Payments\Bova\DTOs\H2HPayment\Get\GetPaymentResponseDTO as H2HGetPaymentResponseDTO;
use App\Integrations\Payments\Bova\DTOs\MarkPaid\MarkPaidRequestDTO;
use App\Integrations\Payments\Bova\DTOs\MarkPaid\MarkPaidResponseDTO;
use App\Integrations\Payments\Bova\DTOs\Rate\GetRatesRequestDTO;
use App\Integrations\Payments\Bova\DTOs\Rate\GetRatesResponseDTO;
use Throwable;

class BovaAPIService extends Api
{
    /**
     * https://api.bovadocs.com/deposits/h2h/create
     */
    public function h2hCreatePayment(H2HPaymentCreateRequestDTO $dto): H2HPaymentCreateResponseDTO
    {
        return new H2HPaymentCreateResponseDTO(isSuccess: true);
    }

    /**
     * https://api.bovadocs.com/deposits/h2h/get
     */
    public function h2hGetPayment(H2HGetPaymentRequestDTO $dto): H2HGetPaymentResponseDTO
    {
        return new H2HGetPaymentResponseDTO(isSuccess: true);
    }

    /**
     * https://api.bovadocs.com/deposits/h2h/paid
     * https://api.bovadocs.com/deposits/h2c/paid
     */
    public function markPaid(MarkPaidRequestDTO $dto): MarkPaidResponseDTO
    {
        return new MarkPaidResponseDTO(isSuccess: true);
    }

    /**
     * https://api.bovadocs.com/deposits/h2h/cancel
     * https://api.bovadocs.com/deposits/h2c/cancel
     */
    public function cancel(CancelRequestDTO $dto): CancelResponseDTO
    {
        return new CancelResponseDTO(isSuccess: true);
    }

    /**
     * https://api.bovadocs.com/deposits/h2c/create
     */
    public function h2cCreatePayment(H2CPaymentCreateRequestDTO $dto): H2CPaymentCreateResponseDTO
    {
        return new H2CPaymentCreateResponseDTO(isSuccess: true);
    }

    /**
     * https://api.bovadocs.com/deposits/h2c/get
     */
    public function h2cGetPayment(H2CGetPaymentRequestDTO $dto): H2CGetPaymentResponseDTO
    {
        return new H2CGetPaymentResponseDTO(isSuccess: true);
    }

    /**
     * https://api.bovadocs.com/disputes/create
     */
    public function createDispute(CreateDisputeRequestDTO $dto): CreateDisputeResponseDTO
    {
        return new CreateDisputeResponseDTO(isSuccess: true);
    }

    /**
     * https://api.bovadocs.com/payouts/create
     */
    public function createPayout(CreatePayoutRequestDTO $dto): CreatePayoutResponseDTO
    {
        return new CreatePayoutResponseDTO(isSuccess: true);
    }

    /**
     * https://api.bovadocs.com/payouts/get
     */
    public function getPayout(GetPayoutRequestDTO $dto): GetPayoutResponseDTO
    {
        return new GetPayoutResponseDTO(isSuccess: true);
    }

    /**
     * https://api.bovadocs.com/accounts/get
     */
    public function getBalances(GetBalancesRequestDTO $dto): GetBalancesResponseDTO
    {
        return new GetBalancesResponseDTO(isSuccess: true);
    }

    /**
     * https://api.bovadocs.com/rates/get
     */
    public function getRates(GetRatesRequestDTO $dto): GetRatesResponseDTO
    {
        return new GetRatesResponseDTO(currencies: []);
    }

    private function call(string $endpoint, string $method, BovaRequestDTO $dto, array $options = []): ?string
    {
        try {
            $client = $this->getClient(
                $dto->baseUrl()
            );

            if ($dto->shouldGenerateSignature()) {
                $options['headers']['Signature'] = self::getSign($dto->toArray(), $dto->getApiKey());
            }

            if ($dto->shouldBearerAuth()) {
                $options['headers']['Authorization'] = 'Bearer ' . $dto->getApiKey();
            }

            if ($dto->shouldSendAsForm()) {
                $options['headers']['form_params'] = $dto->toArray();
            }

            $request = $client->request($method, $endpoint, $options);

            return $request->getBody()->getContents();
        } catch (Throwable $exception) {

            return null;
        }
    }

    protected function baseUrl(): string
    {
        return '';
    }

    /**
     * https://api.bovadocs.com/deposits/h2h/signature
     */
    public static function getSign(array $data, string $apiKey): string
    {
        return hash('sha1', $apiKey . json_encode($data));
    }
}
