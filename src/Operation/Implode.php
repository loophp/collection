<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use CachingIterator;
use Iterator;
use loophp\collection\Contract\EagerOperation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements EagerOperation<TKey, T>
 */
final class Implode extends AbstractEagerOperation implements EagerOperation
{
    public function __construct(string $glue)
    {
        $this->storage['glue'] = $glue;
    }

    public function __invoke(): Closure
    {
        return static function (Iterator $collection, string $glue): string {
            $callback =
                /**
                 * @psalm-param TKey $key
                 * @psalm-param \CachingIterator<TKey, T> $iterator
                 *
                 * @param mixed $key
                 * @param mixed $iterator
                 */
                static function (string $carry, string $item, $key, $iterator) use ($glue): string {
                    $carry .= $item;

                    if ($iterator->hasNext()) {
                        $carry .= $glue;
                    }

                    return $carry;
                };

            return (new Transform(new FoldLeft($callback, '')))(new CachingIterator($collection));
        };
    }
}
