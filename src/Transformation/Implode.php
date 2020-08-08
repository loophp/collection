<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use CachingIterator;
use Iterator;
use loophp\collection\Contract\Transformation;
use loophp\collection\Transformation\AbstractTransformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Implode extends AbstractTransformation implements Transformation
{
    public function __construct(string $glue)
    {
        $this->storage['glue'] = $glue;
    }

    public function __invoke()
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
