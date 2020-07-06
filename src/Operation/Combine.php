<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use const E_USER_WARNING;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, \Generator<TKey, T>>
 * @implements Operation<TKey, T, \Generator<TKey, T>>
 */
final class Combine extends AbstractOperation implements Operation
{
    /**
     * Combine constructor.
     *
     * @psalm-param TKey ...$keys
     *
     * @param mixed ...$keys
     */
    public function __construct(...$keys)
    {
        $this->storage['keys'] = $keys;
    }

    /**
     * @return Closure(\Iterator<TKey, T>, list<TKey>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             * @param list<TKey> $keys
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator, array $keys): Generator {
                $keysIterator = new ArrayIterator($keys);

                while ($iterator->valid() && $keysIterator->valid()) {
                    yield $keysIterator->current() => $iterator->current();

                    $iterator->next();
                    $keysIterator->next();
                }

                if ($iterator->valid() !== $keysIterator->valid()) {
                    trigger_error('Both keys and values must have the same amount of items.', E_USER_WARNING);
                }
            };
    }
}
