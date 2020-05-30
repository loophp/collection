<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Count;
use loophp\collection\Transformation\Run;

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
    public function __invoke(): Closure
    {
        $length = $this->length;

        return static function (iterable $collection) use ($length): Generator {
            yield from (
                new Run(
                    new Skip(
                        (new Count())($collection) - $length
                    ),
                    new Limit($length)
                ))($collection);
        };
    }
}
