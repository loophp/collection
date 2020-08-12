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
final class Only extends AbstractLazyOperation implements LazyOperation
{
    /**
     * @param mixed ...$keys
     * @psalm-param TKey ...$keys
     */
    public function __construct(...$keys)
    {
        $this->storage = [
            'keys' => $keys,
        ];
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
                if ([] === $keys) {
                    return yield from $iterator;
                }

                $keys = array_flip($keys);

                foreach ($iterator as $key => $value) {
                    if (false === array_key_exists($key, $keys)) {
                        continue;
                    }

                    yield $key => $value;
                }
            };
    }
}
