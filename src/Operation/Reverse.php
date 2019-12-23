<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use Closure;
use drupol\collection\Contract\Operation;
use drupol\collection\Transformation\All;
use Generator;

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
