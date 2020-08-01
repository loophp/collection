<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 */
interface Transformable
{
    /**
     * @param \loophp\collection\Contract\Transformation<TKey, T> ...$transformers
     * @psalm-param \loophp\collection\Contract\Transformation<TKey, T> ...$transformers
     *
     * @return \loophp\collection\Iterator\ClosureIterator|mixed
     */
    public function transform(Transformation ...$transformers);
}
