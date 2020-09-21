<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;

use const PHP_EOL;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class Lines extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T|string>): Generator<int, string, mixed, void>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T|string> $iterator
             *
             * @psalm-return Generator<int, string, mixed, void>
             */
            static function (Iterator $iterator): Generator {
                $mapCallback = static function (array $value): string {
                    return implode('', $value);
                };

                /** @psalm-var callable(Iterator<TKey, T|string>): Generator<int, array<int, string>> $explode */
                $explode = Explode::of()(PHP_EOL, "\n", "\r\n");
                /** @psalm-var callable(Iterator<int, array<int, string>>): Generator<int, string> $map */
                $map = Map::of()($mapCallback);

                /** @psalm-var callable(Iterator<TKey, T|string>): Generator<int, string> $compose */
                $compose = Compose::of()($explode, $map);

                return yield from $compose($iterator);
            };
    }
}
