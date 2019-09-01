<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Reduce.
 */
final class Reduce implements Operation
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

        $result = $initial;

        foreach ($collection as $value) {
            $result = $callback($result, $value);
        }

        return $result;
    }
}
