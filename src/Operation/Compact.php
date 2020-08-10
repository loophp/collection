<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use function in_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Operation<TKey, T>
 */
final class Compact extends AbstractGeneratorOperation implements Operation
{
    /**
     * @param mixed ...$values
     * @psalm-param T ...$values
     */
    public function __construct(...$values)
    {
        $this->storage['values'] = [] === $values ? [null] : $values;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param list<T|null> $values
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, array $values): Generator {
                return yield from
                (new Run())()(
                    $iterator,
                    new Filter(
                        /**
                         * @param mixed $item
                         */
                        static function ($item) use ($values): bool {
                            return !in_array($item, $values, true);
                        }
                    )
                );
            };
    }
}
