<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * Class Flatten.
 */
final class Flatten implements Operation
{
    /**
     * @var int
     */
    private $depth;

    /**
     * Flatten constructor.
     *
     * @param int $depth
     */
    public function __construct(int $depth)
    {
        $this->depth = $depth;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        $depth = $this->depth;

        return static function (iterable $collection) use ($depth): Generator {
            foreach ($collection as $value) {
                if (false === is_iterable($value)) {
                    yield $value;
                } elseif (1 === $depth) {
                    foreach ($value as $subValue) {
                        yield $subValue;
                    }
                } else {
                    foreach ((new Run(new Flatten($depth - 1)))($value) as $subValue) {
                        yield $subValue;
                    }
                }
            }
        };
    }
}
