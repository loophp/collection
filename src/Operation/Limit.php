<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use LimitIterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

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
    public function __invoke(): Closure
    {
        $limit = $this->limit;
        $offset = $this->offset;

        return static function (iterable $collection) use ($offset, $limit): Generator {
            yield from new LimitIterator(new IterableIterator($collection), $offset, $limit);
        };
    }
}
