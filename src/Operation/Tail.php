<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use drupol\collection\Transformation\Count;
use Generator;

/**
 * Class Tail.
 */
final class Tail implements Operation
{
    /**
     * @var int
     */
    private $length;

    /**
     * Tail constructor.
     *
     * @param int $length
     */
    public function __construct(int $length)
    {
        $this->length = $length;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $offset = (new Count())->on($collection) - $this->length;
        $length = $this->length;

        return static function () use ($offset, $length, $collection): Generator {
            yield from (new Limit($length))->on((new Skip($offset))->on($collection)())();
        };
    }
}
