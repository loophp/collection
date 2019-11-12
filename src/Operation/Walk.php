<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use Generator;

/**
 * Class Walk.
 */
final class Walk implements Operation
{
    /**
     * @var callable[]
     */
    private $callbacks;

    /**
     * Walk constructor.
     *
     * @param callable ...$callbacks
     */
    public function __construct(callable ...$callbacks)
    {
        $this->callbacks = $callbacks;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $callbacks = $this->callbacks;

        return static function () use ($callbacks, $collection): Generator {
            foreach ($collection as $key => $value) {
                $carry = $value;

                // Custom array_reduce function with the key passed in argument.
                foreach ($callbacks as $callback) {
                    $carry = $callback($carry, $key);
                }

                yield $key => $carry;
            }
        };
    }
}
