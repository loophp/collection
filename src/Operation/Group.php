<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use function array_key_exists;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @extends AbstractOperation<TKey, T, Generator<TKey, T|list<T>>>
 * @implements Operation<TKey, T, Generator<TKey, T|list<T>>>
 */
final class Group extends AbstractOperation implements Operation
{
    /**
     * @param null|callable(TKey, T): (U) $callable
     */
    public function __construct(?callable $callable = null)
    {
        $this->storage['callable'] = $callable ??
            /**
             * @param TKey $key
             * @param T $value
             *
             * @return TKey|U
             */
            static function ($key, $value) {
                return $key;
            };
    }

    /**
     * @return Closure(\Iterator<TKey, T>, callable(TKey, T): U): Generator<U, list<T>|T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             * @param callable(TKey, T): (U) $callable
             *
             * @return Generator<U, list<T>|T>
             */
            static function (Iterator $iterator, callable $callable): Generator {
                $data = [];

                foreach ($iterator as $key => $value) {
                    $key = ($callable)($key, $value);

                    if (false === array_key_exists($key, $data)) {
                        $data[$key] = $value;

                        continue;
                    }

                    $data[$key] = (array) $data[$key];
                    $data[$key][] = $value;
                }

                return yield from $data;
            };
    }
}
