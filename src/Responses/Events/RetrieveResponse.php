<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Responses\Events;

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
        public readonly bool $allDay,
        public readonly array $attachments,
        public readonly int $attendeeCount,
        public readonly int $attendeeLimit,
        public readonly string $details,
        public readonly string $endAt,
        public readonly string $id,
        public readonly string $locationId,
        public readonly int $maxTicketsPerBooking,
        public readonly string $startAt,
        public readonly array $tickets,
        public readonly string $title,
        public readonly bool $waitingList
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
            $attributes['attributes']['all_day'],
            $attributes['relationships']['tickets']['data'],
            $attributes['attributes']['attendee_count'],
            $attributes['attributes']['attendee_limit'],
            $attributes['attributes']['details'],
            $attributes['attributes']['end_at'],
            $attributes['id'],
            $attributes['relationships']['location']['data']['id'],
            $attributes['attributes']['max_tickets_per_booking'],
            $attributes['attributes']['start_at'],
            $attributes['relationships']['tickets']['data'],
            $attributes['attributes']['title'],
            $attributes['attributes']['waiting_list']
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            //'attributes' => $this->attributes,
        ];
    }
}