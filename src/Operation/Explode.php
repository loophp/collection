<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\LazyOperation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements LazyOperation<TKey, T>
 */
final class Explode extends AbstractLazyOperation implements LazyOperation
{
    /**
     * @param mixed ...$explodes
     * @psalm-param T ...$explodes
     */
    public function __construct(...$explodes)
    {
        $this->storage['explodes'] = $explodes;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param list<T> $explodes
             *
             * @psalm-return \Generator<int, list<T>>
             */
            static function (Iterator $iterator, array $explodes): Generator {
                return yield from (new Run())()(
                    $iterator,
                    new Split(
                        ...array_map(
                            /**
                             * @param mixed $explode
                             * @psalm-param T $explode
                             */
                            static function ($explode): Closure {
                                return
                                    /**
                                     * @param mixed $value
                                     * @psalm-param T $value
                                     */
                                    static function ($value) use ($explode): bool {
                                        return $value === $explode;
                                    };
                            },
                            $explodes
                        )
                    )
                );
            };
    }
}
