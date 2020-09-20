<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface FoldRight1able
{
    /**
     * @return mixed
     * @psalm-return T|null
     */
    public function foldRight1(callable $callback);
}
