<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Operation.
 */
interface Operation
{
    /**
     * @param \drupol\collection\Contract\Collection $collection
     *
     * @return mixed
     */
    public function run(Collection $collection);

    /**
     * @param mixed ...$parameters
     *
     * @return \drupol\collection\Contract\Operation
     */
    public static function with(...$parameters): self;
}
