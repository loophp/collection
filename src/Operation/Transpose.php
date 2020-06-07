<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use MultipleIterator;

/**
 * Class Transpose.
 */
final class Transpose implements Operation
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        return static function (iterable $collection): Generator {
            $mit = new MultipleIterator(MultipleIterator::MIT_NEED_ANY);

            foreach ($collection as $collectionItem) {
                $mit->attachIterator(new IterableIterator($collectionItem));
            }

            foreach ($mit as $key => $value) {
                yield current($key) => $value;
            }
        };
    }
}
