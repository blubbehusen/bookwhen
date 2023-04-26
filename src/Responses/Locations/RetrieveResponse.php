<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Responses\Locations;

use InShore\Bookwhen\Contracts\ResponseContract;
use InShore\Bookwhen\Responses\Concerns\ArrayAccessible;

//use OpenAI\Testing\Responses\Concerns\Fakeable;

/**
 * @implements ResponseContract<array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>
 */
final class RetrieveResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}>
     */
    use ArrayAccessible;

    //use Fakeable;

    /**
     * @param  array<array-key, mixed>|null  $statusDetails
     */
    private function __construct(
        public readonly null | string $addressText,
        public readonly null | string $additionalInfo,
        public readonly string $id,
        public readonly float | null $latitude,
        public readonly float | null $longitude,
        public readonly null | string $mapUrl,
        public readonly int | null $zoom
    ) {
    }

    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  array{id: string, object: string, created_at: int, bytes: int, filename: string, purpose: string, status: string, status_details: array<array-key, mixed>|string|null}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['attributes']['address_text'],
            $attributes['attributes']['additional_info'],
            $attributes['id'],
            $attributes['attributes']['latitude'],
            $attributes['attributes']['longitude'],
            $attributes['attributes']['map_url'],
            $attributes['attributes']['zoom']
        );
    }
}
