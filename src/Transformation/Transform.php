<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @template V
 * @implements Transformation<TKey, T, \loophp\collection\Iterator\ClosureIterator<TKey, T, U>>
 */
final class Transform implements Transformation
{
    /**
     * @var array<int, \loophp\collection\Contract\Transformation>
     */
    private $transformers;

    /**
     * @param \loophp\collection\Contract\Transformation<TKey, T, U> ...$transformers
     */
    public function __construct(Transformation ...$transformers)
    {
        $this->transformers = $transformers;
    }

    public function __invoke(iterable $collection)
    {
        return (new FoldLeft(
            /**
             * @param iterable<TKey, T> $collection
             * @param \loophp\collection\Contract\Transformation<TKey, T, U> $transformer
             *
             * @return iterable<TKey, T>|U
             */
            static function (iterable $collection, Transformation $transformer) {
                return $transformer($collection);
            },
            $collection
        ))($this->transformers);
    }
}
