<?php

declare(strict_types=1);

namespace App\Services\V1\Integrations\Payment\DTOs\Callbacks;

use Illuminate\Support\Carbon;

class NotifyWebhookBodyDTO
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $event,
        public readonly Carbon $createdAt,
        public readonly NotifyWebhookBodyPayloadDTO $payload,
        public int $tries = 1,
    ) {}

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'event' => $this->event,
            'created_at' => $this->createdAt->toIso8601String(),
            'tries' => $this->tries,
            'payload' => $this->payload->toArray(),
        ];
    }
}
