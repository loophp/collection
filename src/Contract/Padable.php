<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Padable.
 */
interface Padable
{
    /**
     * TODO: Pad.
     *
     * @param int $size
     * @param mixed $value
     *
     * @return \drupol\collection\Contract\Collection<mixed>
     */
    public function pad(int $size, $value): Base;
}
