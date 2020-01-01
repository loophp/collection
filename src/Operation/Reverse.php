<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\All;

/**
 * Class Reverse.
 */
final class Reverse implements Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        return static function () use ($collection): Generator {
            $all = (new All())->on($collection);

            for (end($all); null !== ($key = key($all)); prev($all)) {
                yield $key => current($all);
            }
        };
    }
}
