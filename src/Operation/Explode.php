<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @template U
 * @extends AbstractOperation<TKey, T, Generator<int, array<int, T>>>
 * @implements Operation<TKey, T, Generator<int, array<int, T>>>
 */
final class Explode extends AbstractOperation implements Operation
{
    /**
     * Explode constructor.
     *
     * @param U ...$explodes
     */
    public function __construct(...$explodes)
    {
        $this->storage['explodes'] = $explodes;
    }

    /**
     * @return Closure(\Iterator<TKey, T>, array<int, U>): \Generator<int, array<int, T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             * @param array<int, U> $explodes
             *
             * @return Generator<int, array<int, T>>
             */
            static function (Iterator $iterator, array $explodes): Generator {
                yield from (new Run(
                    new Split(
                        ...array_map(
                            /**
                             * @param float|int|string $explode
                             */
                            static function ($explode) {
                                return
                                    /** @param mixed $value */
                                    static function ($value) use ($explode): bool {
                                        return $value === $explode;
                                    };
                            },
                            $explodes
                        )
                    )
                ))($iterator);
            };
    }
}
