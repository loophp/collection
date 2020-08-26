<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\FoldLeft;
use loophp\collection\Transformation\Transform;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Group extends AbstractOperation implements Operation
{
    /**
     * @psalm-return Closure(null|callable(TKey, T):(TKey)): Closure(Iterator<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param null|callable(TKey, T):(T|TKey) $callable
             */
            static function (?callable $callable = null): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<int, list<T>>
                     */
                    static function (Iterator $iterator) use ($callable): Generator {
                        $callable = $callable ??
                            /**
                             * @param mixed $key
                             * @psalm-param TKey $key
                             *
                             * @param mixed $value
                             * @psalm-param T $value
                             *
                             * @return mixed
                             * @psalm-return TKey
                             */
                            static function ($value, $key) {
                                return $key;
                            };

                        $callback =
                            /**
                             * @psalm-param array<TKey, list<T>> $collect
                             *
                             * @param mixed $value
                             * @psalm-param T $value
                             *
                             * @param mixed $key
                             * @psalm-param TKey $key
                             *
                             * @psalm-return array<TKey, list<T>>
                             */
                            static function (array $collect, $value, $key) use ($callable): array {
                                if (null !== $groupKey = $callable($value, $key)) {
                                    $collect[$groupKey][] = $value;
                                } else {
                                    $collect[$key] = $value;
                                }

                                return $collect;
                            };

                        return yield from (new Transform(new FoldLeft($callback, [])))($iterator);
                    };
            };
    }
}
