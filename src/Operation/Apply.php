<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

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
    public function on(iterable $collection): \Closure
    {
        $callbacks = $this->callbacks;

        return static function () use ($callbacks, $collection): iterable {
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
