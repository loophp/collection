<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Reduction.
 */
final class Reduction extends Operation
{
    /**
     * Reduction constructor.
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
    public function on(iterable $collection)
    {
        [$callback, $initial] = $this->parameters;

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
