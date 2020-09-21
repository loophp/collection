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
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Words extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, string, mixed, void>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, string> $iterator
             *
             * @psalm-return Generator<TKey, string, mixed, void>
             */
            static function (Iterator $iterator): Generator {
                $mapCallback = static function (array $value): string {
                    return implode('', $value);
                };

                /** @psalm-var callable(Iterator<TKey, T>): Generator<TKey, T> $explode */
                $explode = Explode::of()("\t", "\n", ' ');
                /** @psalm-var callable(Iterator<TKey, T>): Generator<TKey, string> $map */
                $map = Map::of()($mapCallback);
                /** @psalm-var callable(Iterator<TKey, T>): Generator<TKey, string> $compact */
                $compact = Compact::of()();

                /** @psalm-var callable(Iterator<TKey, string>): Generator<TKey, string> $compose */
                $compose = Compose::of()($explode, $map, $compact);

                return yield from $compose($iterator);
            };
    }
}
