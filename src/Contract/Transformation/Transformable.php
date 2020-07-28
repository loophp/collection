<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 */
interface Transformable
{
    /**
     * @param \loophp\collection\Contract\Transformation<TKey, T, U> ...$transformers
     *
     * @return bool|int|string|T
     */
    public function transform(Transformation ...$transformers);
}
