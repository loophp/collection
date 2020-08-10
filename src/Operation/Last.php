<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Operation<TKey, T>
 */
final class Last extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (Iterator $collection) {
            return (new Run())()($collection, new FoldLeft(
                /**
                 * @param mixed $carry
                 * @psalm-param null|T $carry
                 *
                 * @param mixed $item
                 * @psalm-param T $item
                 *
                 * @param mixed $key
                 * @psalm-param TKey $key
                 *
                 * @return mixed
                 * @psalm-return T
                 */
                static function ($carry, $item, $key) {
                    return $item;
                }
            ));
        };
    }
}
