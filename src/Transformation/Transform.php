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

    public function __invoke(iterable $collection)
    {
        return (new FoldLeft(
            /** @return mixed */
            static function (iterable $collection, Transformation $transformer) {
                return $transformer($collection);
            },
            $collection
        ))($this->transformers);
    }
}
