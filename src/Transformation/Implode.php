<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use CachingIterator;
use Closure;
use Iterator;
use loophp\collection\Contract\Transformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Implode implements Transformation
{
    public function __invoke()
    {
        return static function (string $glue): Closure {
            return static function (Iterator $iterator) use ($glue): string {
                $callback =
                    /**
                     * @psalm-param TKey $key
                     * @psalm-param \CachingIterator $iterator
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

                $foldLeft = (new FoldLeft())()($callback)('');

                return (string) (new Transform())()($foldLeft)(new CachingIterator($iterator));
            };
        };
    }
}
