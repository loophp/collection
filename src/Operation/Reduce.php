<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Reduce.
 */
final class Reduce extends Operation
{
    /**
     * Reduce constructor.
     *
     * @param callable $callback
     * @param mixed $initial
     */
    public function __construct(callable $callback, $initial)
    {
        parent::__construct(...[$callback, $initial]);
    }

    /**
     * {@inheritdoc}
     */
    public function on(\Traversable $collection)
    {
        [$callback, $initial] = $this->parameters;

        $result = $initial;

        foreach ($collection as $value) {
            $result = $callback($result, $value);
        }

        return $result;
    }
}
