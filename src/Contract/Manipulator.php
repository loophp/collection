<?php

declare(strict_types=1);

namespace drupol\collection\Contract;

/**
 * Interface Manipulator.
 */
interface Manipulator
{
    /**
     * @param \IteratorAggregate $collection
     *
     * @return bool|\drupol\collection\Contract\Collection|int|mixed|\Traversable
     */
    public function run(\IteratorAggregate $collection);

    /**
     * @param mixed ...$parameters
     *
     * @return \drupol\collection\Contract\Manipulator
     */
    public static function with(...$parameters): self;
}
