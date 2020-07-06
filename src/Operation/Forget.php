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
 * @extends AbstractOperation<TKey, T, Generator<TKey, T>>
 * @implements Operation<TKey, T, Generator<TKey, T>>
 */
final class Forget extends AbstractOperation implements Operation
{
    /**
     * Forget constructor.
     *
     * @param U ...$keys
     */
    public function __construct(...$keys)
    {
        $this->storage['keys'] = $keys;
    }

    /**
     * @return Closure(\Iterator<TKey, T>, list<U>): \Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             * @param list<U> $keys
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator, array $keys): Generator {
                $keys = array_flip($keys);

                foreach ($iterator as $key => $value) {
                    if (false === array_key_exists($key, $keys)) {
                        yield $key => $value;
                    }
                }
            };
    }
}
