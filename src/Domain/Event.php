<?php

declare(strict_types=1);

namespace InShore\Bookwhen\Domain;

use InShore\Bookwhen\Domain\Location;

final class Event
{
    /**
     *
     */
    public readonly int $attendeeAvailable;

    /**
     *
     */
    public readonly bool $finished;

    /**
     *
     */
    public readonly bool $soldOut;

    /**
     *
     *
     */
    public function __construct(
        public readonly bool $allDay,
        public array $attachments,
        public readonly int $attendeeCount,
        public readonly int $attendeeLimit,
        public readonly string $details,
        public readonly string $endAt,
        public readonly string $id,
        public readonly Location $location,
        public readonly int $maxTicketsPerBooking,
        public readonly string $startAt,
        public array $tickets,
        public readonly string $title,
        public readonly bool $waitingList
    ) {
        $this->attendeeAvailable = $this->attendeeLimit - $this->attendeeCount;
        $this->finished = false; // @todo
        $this->soldOut = ($this->attendeeCount === $this->attendeeLimit);
    }



}