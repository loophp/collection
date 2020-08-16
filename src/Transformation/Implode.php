<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use CachingIterator;
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
    /**
     * @var string
     */
    private $glue;

    public function __construct(string $glue)
    {
        $this->glue = $glue;
    }

    public function __invoke(Iterator $collection): string
    {
        $glue = $this->glue;

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

        return (string) (new Transform(new FoldLeft($callback, '')))(new CachingIterator($collection));
    }
}
