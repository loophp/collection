<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Operation<TKey, T>
 */
final class First extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (?callable $callback = null): Closure {
            return static function (int $size = 1) use ($callback): Closure {
                return
                    /**
                     * @psalm-param \Iterator<TKey, T> $iterator
                     *
                     * @psalm-return \Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($callback, $size): Generator {
                        $defaultCallback =
                            /**
                             * @param mixed $value
                             * @param mixed $key
                             * @psalm-param T $value
                             * @psalm-param TKey $key
                             * @psalm-param Iterator<TKey, T> $iterator
                             */
                            static function ($value, $key, Iterator $iterator): bool {
                                return true;
                            };

                        $callback = $callback ?? $defaultCallback;

                        $filter = (new Filter())()($callback);
                        $limit = (new Limit())()($size)(0);

                        return yield from (new Run())()($filter, $limit)($iterator);
                    };
            };
        };
    }
}
