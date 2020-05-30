<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\SortableIterableIterator;

/**
 * Class Sort.
 *
 * Be careful, this will only work with finite collection sets.
 */
final class Sort implements Operation
{
    /**
     * @var callable|null
     */
    private $callback;

    /**
     * Sort constructor.
     *
     * @param callable $callback
     */
    public function __construct(?callable $callback = null)
    {
        $this->callback = $callback;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        $callback = $this->callback;

        return static function (iterable $collection) use ($callback): Generator {
            if (null === $callback) {
                $callback = static function ($left, $right): int {
                    return $left <=> $right;
                };
            }

            yield from new SortableIterableIterator($collection, $callback);
        };
    }
}
