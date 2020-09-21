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
final class Unwords extends AbstractOperation
{
    /**
     * @psalm-return Closure(Iterator<TKey, T|string>): Generator<TKey, T|string, mixed, void>
     */
    public function __invoke(): Closure
    {
        /**
         * @psalm-param Iterator<TKey, T|string> $iterator
         *
         * @psalm-return Generator<TKey, string>
         */
        return static function (Iterator $iterator): Generator {
            /** @psalm-var callable(Iterator<TKey, T|string>): Generator<TKey, string> $implode */
            $implode = Implode::of()(' ');

            return $implode($iterator);
        };
    }
}
