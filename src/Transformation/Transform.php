<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use ArrayIterator;
use Iterator;
use loophp\collection\Contract\Transformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Transform implements Transformation
{
    /**
     * @var ArrayIterator<int, \loophp\collection\Contract\Transformation<TKey, T>>
     */
    private $transformers;

    /**
     * @param \loophp\collection\Contract\Transformation<TKey, T> ...$transformers
     */
    public function __construct(Transformation ...$transformers)
    {
        $this->transformers = new ArrayIterator($transformers);
    }

    /**
     * @psalm-param Iterator<TKey, T> $collection
     *
     * @return mixed|null
     * @psalm-return Iterator<TKey, T>|T
     */
    public function __invoke(Iterator $collection)
    {
        return (new FoldLeft(
            /**
             * @psalm-param Iterator<TKey, T> $collection
             * @psalm-param Transformation<TKey, T> $transformer
             * @psalm-param TKey $key
             *
             * @param mixed $key
             *
             * @psalm-return T
             */
            static function (Iterator $collection, Transformation $transformer, $key) {
                return $transformer($collection);
            },
            $collection
        ))($this->transformers);
    }
}
