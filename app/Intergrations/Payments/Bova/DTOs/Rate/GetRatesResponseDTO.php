<?php

declare(strict_types=1);

namespace App\Integrations\Payments\Bova\DTOs\Rate;

class GetRatesResponseDTO
{
    /**
     * @param  array<string>  $currencies
     */
    public function __construct(
        public readonly array $currencies,
    ) {}

    public static function fromResponse(array $response): self
    {
        return new self($response);
    }
}
