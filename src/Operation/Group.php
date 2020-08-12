<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\LazyOperation;

use function array_key_exists;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements LazyOperation<TKey, T>
 */
final class Group extends AbstractLazyOperation implements LazyOperation
{
    public function __construct(?callable $callable = null)
    {
        $this->storage['callable'] = $callable ??
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
            static function ($key, $value) {
                return $key;
            };
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param callable(TKey, T):(TKey) $callable
             *
             * @psalm-return \Generator<int, list<T>>
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
