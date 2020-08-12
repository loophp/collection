<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use loophp\collection\Contract\EagerOperation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements EagerOperation<TKey, T>
 */
final class Truthy extends AbstractEagerOperation implements EagerOperation
{
    /**
     * @psalm-return \Closure(\Iterator<TKey, T>): bool
     */
    public function __invoke(): Closure
    {
        return static function (Iterator $collection): bool {
            foreach ($collection as $key => $value) {
                if (false === (bool) $value) {
                    return false;
                }
            }

            return true;
        };
    }
}
