<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

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
                new IterableIterator($collection)
            );

            uasort($array, $callback);

            yield from $array;
        };
    }
}
