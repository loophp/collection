<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface FoldLeft1able
{
    /**
     * @return mixed
     * @psalm-return T|null
     */
    public function foldLeft1(callable $callback);
}
