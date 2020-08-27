<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use function array_key_exists;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Forget extends AbstractOperation implements Operation
{
    /**
     * @psalm-return Closure(TKey...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param TKey ...$keys
             */
            static function (...$keys): Closure {
                return
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<TKey, T>
                     */
                    static function (Iterator $iterator) use ($keys): Generator {
                        $keys = array_flip($keys);

                        foreach ($iterator as $key => $value) {
                            if (false === array_key_exists($key, $keys)) {
                                yield $key => $value;
                            }
                        }
                    };
            };
    }
}
