<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * Class RSample.
 */
final class RSample implements Operation
{
    /**
     * @var float
     */
    private $probability;

    /**
     * RSample constructor.
     *
     * @param float $probability
     */
    public function __construct(float $probability)
    {
        $this->probability = $probability;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        $probability = $this->probability;

        return static function (iterable $collection) use ($probability): Generator {
            yield from (new Run(
                new Filter(
                    static function () use ($probability): bool {
                        return (mt_rand() / mt_getrandmax()) < $probability;
                    }
                )
            ))($collection);
        };
    }
}
