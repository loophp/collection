<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Coalesce extends AbstractOperation
{
    /**
     * @psalm-return Closure(\Iterator<TKey, T>): \Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        /** @psalm-var Closure(\Iterator<TKey, T>): \Generator<TKey, T> $pipe */
        $pipe = Pipe::of()(
            Compact::of()(),
            Head::of(),
        );

        // Point free style.
        return $pipe;
    }
}
