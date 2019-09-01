<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Reduction.
 */
final class Reduction implements Operation
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @var mixed
     */
    private $initial;

    /**
     * Reduction constructor.
     *
     * @param callable $callback
     * @param mixed $initial
     */
    public function __construct(callable $callback, $initial)
    {
        $this->callback = $callback;
        $this->initial = $initial;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        $callback = $this->callback;
        $initial = $this->initial;

        return static function () use ($callback, $initial, $collection) {
            $result = $initial;

            yield $initial;

            foreach ($collection as $value) {
                $result = $callback($result, $value);

                yield $result;
            }
        };
    }
}
