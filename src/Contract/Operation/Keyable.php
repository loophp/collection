<?php

declare(strict_types=1);

namespace loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
interface Keyable
{
    /**
     * @psalm-return T|TKey
     */
    public function key(int $index = 0);
}
