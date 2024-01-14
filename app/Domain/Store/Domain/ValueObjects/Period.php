<?php

namespace App\Domain\Store\Domain\ValueObjects;

use App\Domain\Store\Domain\Exceptions\PeriodStartLaterThanStopException;
use Carbon\CarbonImmutable;

final readonly class Period
{
    /**
     * @throws PeriodStartLaterThanStopException
     */
    private function __construct(
        private CarbonImmutable $start,
        private CarbonImmutable $stop,
    ) {
        if ($this->start->greaterThanOrEqualTo($this->stop)) {
            throw PeriodStartLaterThanStopException::create($this->start, $this->stop);
        }
    }

    /**
     * @throws PeriodStartLaterThanStopException
     */
    public static function make(CarbonImmutable $start, CarbonImmutable $end): self
    {
        return new self($start, $end);
    }

    public function getStart(): CarbonImmutable
    {
        return $this->start;
    }

    public function getEnd(): CarbonImmutable
    {
        return $this->stop;
    }
}
