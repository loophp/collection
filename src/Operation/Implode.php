<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use CachingIterator;
use Closure;
use Generator;
use Iterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Implode extends AbstractOperation
{
    public function __invoke(): Closure
    {
        return static function (string $glue): Closure {
            return static function (Iterator $iterator) use ($glue): Generator {
                $callback =
                    /**
                     * @psalm-param TKey $key
                     * @psalm-param CachingIterator $iterator
                     *
                     * @param mixed $key
                     * @param mixed $iterator
                     */
                    static function (string $carry, string $item, $key, CachingIterator $iterator) use ($glue): string {
                        $carry .= $item;

                        if ($iterator->hasNext()) {
                            $carry .= $glue;
                        }

                        return $carry;
                    };

                return yield from FoldLeft::of()($callback)('')(new CachingIterator($iterator));
            };
        };
    }
}
