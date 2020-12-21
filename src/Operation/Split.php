<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation\Splitable;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Split extends AbstractOperation
{
    /**
     * @psalm-return Closure(int): Closure((callable(T, TKey): bool)...): Closure(Iterator<TKey, T>): Generator<int, list<T>>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure((callable(T, TKey): bool)...): Closure(Iterator<TKey, T>): Generator<int, list<T>>
             */
            static fn (int $type = Splitable::BEFORE): Closure =>
                /**
                 * @psalm-param callable(T, TKey): bool ...$callbacks
                 *
                 * @psalm-return Closure(Iterator<TKey, T>): Generator<int, list<T>>
                 */
                static fn (callable ...$callbacks): Closure =>
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<int, list<T>>
                     */
                    static function (Iterator $iterator) use ($type, $callbacks): Generator {
                        $carry = [];

                        $reducer =
                            /**
                             * @param mixed $key
                             * @psalm-param TKey $key
                             *
                             * @psalm-return Closure(T): Closure(bool, callable(T, TKey): bool): bool
                             */
                            static fn ($key): Closure =>
                                /**
                                 * @param mixed $value
                                 * @psalm-param T $value
                                 *
                                 * @psalm-return Closure(bool, callable(T, TKey): bool): bool
                                 */
                                static fn ($value): Closure =>
                                    /**
                                     * @psalm-param callable(T, TKey): bool $callback
                                     */
                                    static fn (bool $carry, callable $callback): bool => $callback($value, $key) || $carry;

                        for (; $iterator->valid(); $iterator->next()) {
                            $key = $iterator->key();
                            $current = $iterator->current();

                            $callbackReturn = array_reduce($callbacks, $reducer($key)($current), false);

                            if (Splitable::AFTER === $type) {
                                $carry[] = $current;
                            }

                            if (Splitable::REMOVE === $type && true === $callbackReturn) {
                                yield $carry;

                                $carry = [];

                                continue;
                            }

                            if (true === $callbackReturn && [] !== $carry) {
                                yield $carry;

                                $carry = [];
                            }

                            if (Splitable::BEFORE === $type || Splitable::REMOVE === $type) {
                                $carry[] = $current;
                            }
                        }

                        if ([] !== $carry) {
                            yield $carry;
                        }
                    };
    }
}
