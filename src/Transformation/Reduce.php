<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Transformation;

/**
 * Class Reduce.
 */
final class Reduce implements Transformation
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
     * Reduce constructor.
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

        $carry = $initial;

        foreach ($collection as $key => $value) {
            $carry = $callback($carry, $value, $key);
        }

        return $carry;
    }
}
