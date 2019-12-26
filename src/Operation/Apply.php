<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use Generator;

/**
 * Class Apply.
 */
final class Apply implements Operation
{
    /**
     * @var callable[]
     */
    private $callbacks;

    /**
     * Apply constructor.
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
            foreach ($callbacks as $callback) {
                foreach ($collection as $key => $value) {
                    if (false === $callback($value, $key)) {
                        break;
                    }
                }
            }

            yield from $collection;
        };
    }
}
