<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Transformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Transformable
{
    public function transform(callable ...$transformers);
}
