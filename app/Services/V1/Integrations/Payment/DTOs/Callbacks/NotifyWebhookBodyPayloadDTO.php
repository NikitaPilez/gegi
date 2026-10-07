<?php

declare(strict_types=1);

namespace App\Services\V1\Integrations\Payment\DTOs\Callbacks;

use App\Helpers\RSAHelper;
use App\Services\V1\Payment\Enums\DepositStatus;
use Illuminate\Support\Carbon;

class NotifyWebhookBodyPayloadDTO
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $publicKey,
        public readonly int $paymentCurrencyId,
        public readonly int $merchantCurrencyId,
        public readonly float $initialAmount,
        public readonly float $amount,
        public readonly float $approvedAmount,
        public readonly float $totalAmount,
        public readonly DepositStatus $status,
        public readonly Carbon $createdAt,
        public readonly string|int $idempotencyKey,
        public readonly ?Carbon $approvedAt = null,
        public readonly ?int $referenceIdempotencyKey = null,
    ) {}

    public function toArray(): array
    {
        $encrypted = RSAHelper::encryptWithPublicKey(json_encode([
            'uuid' => $this->uuid,
            'idempotencyKey' => $this->idempotencyKey,
            'initial_amount' => $this->initialAmount,
        ]), $this->publicKey);

        return [
            'uuid' => $this->uuid,
            'encrypted' => $encrypted,
            'initial_amount' => [
                $this->paymentCurrencyId => $this->initialAmount,
            ],
            'amount' => [
                $this->paymentCurrencyId => $this->amount,
            ],
            'approved_amount' => [
                $this->paymentCurrencyId => $this->approvedAmount,
            ],
            'total_amount' => [
                $this->paymentCurrencyId => $this->totalAmount,
            ],
            'status' => $this->status->value,
            'created_at' => $this->createdAt->toDateTimeString(),
            'idempotency_key' => $this->idempotencyKey,
            'approved_at' => $this->approvedAt?->toDateTimeString(),
            'reference_idempotency_key' => $this->referenceIdempotencyKey,
        ];
    }
}
