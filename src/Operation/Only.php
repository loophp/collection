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
 * @extends AbstractOperation<TKey, T, Generator<TKey, T>>
 * @implements Operation<TKey, T, Generator<TKey, T>>
 */
final class Only extends AbstractOperation implements Operation
{
    /**
     * Only constructor.
     *
     * @param TKey ...$keys
     */
    public function __construct(...$keys)
    {
        $this->storage = [
            'keys' => $keys,
        ];
    }

    /**
     * @return Closure(\Iterator<TKey, T>, list<TKey>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return static function (Iterator $iterator, array $keys): Generator {
            if ([] === $keys) {
                return yield from $iterator;
            }

            $keys = array_flip($keys);

            foreach ($iterator as $key => $value) {
                if (true === array_key_exists($key, $keys)) {
                    yield $key => $value;
                }
            }
        };
    }
}
