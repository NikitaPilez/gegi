<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs;

use App\Integrations\DTOs\RequestDTO;

abstract class BovaRequestDTO extends RequestDTO
{
    public function baseUrl(): string
    {
        return config('services.bova.url');
    }

    public function userUUId(): string
    {
        return config('services.bova.user_uuid');
    }

    public function getApiKey(): string
    {
        return config('services.bova.api_key');
    }

    public function shouldGenerateSignature(): bool
    {
        return false;
    }

    public function shouldBearerAuth(): bool
    {
        return false;
    }

    public function shouldSendAsForm(): bool
    {
        return false;
    }
}
