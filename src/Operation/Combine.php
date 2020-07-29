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
 */
final class Combine extends AbstractOperation implements Operation
{
    /**
     * Combine constructor.
     *
     * @param mixed ...$keys
     * @psalm-param TKey ...$keys
     */
    public function __construct(...$keys)
    {
        $this->storage['keys'] = $keys;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param list<TKey> $keys
             *
             * @psalm-return \Generator<TKey, T>
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
