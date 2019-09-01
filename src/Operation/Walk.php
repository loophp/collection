<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

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
    public function on(iterable $collection): \Closure
    {
        $callbacks = $this->callbacks;

        return static function () use ($callbacks, $collection): \Generator {
            $callback = static function ($carry, $callback) {
                return $callback($carry);
            };

            foreach ($collection as $key => $value) {
                yield $key => \array_reduce($callbacks, $callback, $value);
            }
        };
    }
}
