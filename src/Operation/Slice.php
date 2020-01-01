<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\ClosureIterator;

/**
 * Class Slice.
 */
final class Slice implements Operation
{
    /**
     * @var int|null
     */
    private $length;

    /**
     * @var int
     */
    private $offset;

    /**
     * Slice constructor.
     *
     * @param int $offset
     * @param int|null $length
     */
    public function __construct(int $offset, ?int $length = null)
    {
        $this->offset = $offset;
        $this->length = $length;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $offset = $this->offset;
        $length = $this->length;

        return static function () use ($offset, $length, $collection): Generator {
            if (null === $length) {
                yield from (new Skip($offset))->on($collection)();
            } else {
                $limit = new Limit($length);
                $skip = new Skip($offset);

                yield from $limit->on(new ClosureIterator($skip->on($collection)))();
            }
        };
    }
}
