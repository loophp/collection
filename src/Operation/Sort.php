<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use drupol\collection\Iterator\ClosureIterator;
use Generator;

/**
 * Class Sort.
 *
 * Be careful, this will only work with finite collection sets.
 */
final class Sort implements Operation
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * Sort constructor.
     *
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $callback = $this->callback;

        return static function () use ($callback, $collection): Generator {
            $array = iterator_to_array(
                new ClosureIterator(
                    static function () use ($collection): Generator {
                        foreach ($collection as $key => $value) {
                            yield $key => $value;
                        }
                    }
                )
            );

            uasort($array, $callback);

            yield from $array;
        };
    }
}
