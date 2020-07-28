<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Iterator;
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
     * @var array<int, \loophp\collection\Contract\Transformation<TKey, T, U>>
     */
    private $transformers;

    /**
     * @param \loophp\collection\Contract\Transformation<TKey, T, U> ...$transformers
     */
    public function __construct(Transformation ...$transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * @param iterable<TKey, T> $collection
     *
     * @return iterable<TKey, T>|U
     */
    public function __invoke(iterable $collection)
    {
        return (new FoldLeft(
            /**
             * @param iterable<TKey, T> $collection
             * @param \loophp\collection\Contract\Transformation<TKey, T, U> $transformer
             * @param mixed $key
             *
             * @return Iterator<TKey, T>|U
             */
            static function (iterable $collection, Transformation $transformer, $key) {
                return $transformer($collection);
            },
            $collection
        ))($this->transformers);
    }
}
