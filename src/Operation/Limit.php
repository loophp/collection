<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use drupol\collection\Iterator\IterableIterator;
use Generator;
use LimitIterator;

/**
 * Class Limit.
 */
final class Limit implements Operation
{
    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    /**
     * Limit constructor.
     *
     * @param int $limit
     * @param int $offset
     */
    public function __construct(int $limit, int $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $limit = $this->limit;
        $offset = $this->offset;

        return static function () use ($collection, $offset, $limit): Generator {
            yield from new LimitIterator(new IterableIterator($collection), $offset, $limit);
        };
    }
}
