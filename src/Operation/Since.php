<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Since extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T , TKey ): bool ...):Closure (Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey):bool ...$callbacks
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (callable ...$callbacks): Closure => static function (Iterator $iterator) use ($callbacks): Generator {
                $reducer =
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Closure(bool, callable(T, TKey): bool): bool
                     */
                    static fn (Iterator $iterator): Closure => static fn (bool $carry, callable $callback): bool => ($callback($iterator->current(), $iterator->key())) ?
                        $carry :
                        false;

                while ($iterator->valid()) {
                    $result = array_reduce($callbacks, $reducer($iterator), true);

                    if (false !== $result) {
                        break;
                    }

                    $iterator->next();
                }

                for (; $iterator->valid(); $iterator->next()) {
                    yield $iterator->key() => $iterator->current();
                }
            };
    }
}
