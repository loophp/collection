<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 *
 * @implements Transformation<TKey, T>
 */
final class Transform implements Transformation
{
    /**
     * @var array<int, \loophp\collection\Contract\Transformation<TKey, T>>
     */
    private $transformers;

    /**
     * @param \loophp\collection\Contract\Transformation<TKey, T> ...$transformers
     */
    public function __construct(Transformation ...$transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * @psalm-param iterable<TKey, T> $collection
     *
     * @return mixed|null
     * @psalm-return T|null
     */
    public function __invoke(iterable $collection)
    {
        return (new FoldLeft(
            /**
             * @psalm-param iterable<TKey, T> $collection
             * @psalm-param Transformation<TKey, T> $transformer
             *
             * @psalm-return T
             */
            static function (iterable $collection, Transformation $transformer) {
                return $transformer($collection);
            },
            $collection
        ))($this->transformers);
    }
}
