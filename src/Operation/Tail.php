<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Count;

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
    public function __construct(int $length = 1)
    {
        $this->length = $length;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $length = $this->length;

        return static function () use ($length, $collection): Generator {
            yield from (new Limit($length))
                ->on(
                    (new Skip((new Count())->on($collection) - $length))
                        ->on($collection)()
                )();
        };
    }
}
