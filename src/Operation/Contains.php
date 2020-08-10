<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Operation<TKey, T>
 */
final class Contains extends AbstractOperation implements Operation
{
    /**
     * @param mixed ...$value
     * @psalm-param T ...$value
     */
    public function __construct(...$value)
    {
        $this->storage['value'] = new ArrayIterator($value);
    }

    public function __invoke(): Closure
    {
        return static function (Iterator $collection, ArrayIterator $values): bool {
            return (new Run(new FoldLeft(
                static function (bool $carry, $item, $key) use ($collection) {
                    $hasCallback = static function ($k, $v) use ($item) {
                        return $item;
                    };

                    return ((new Run(new Has($hasCallback))))()($collection) ?
                        $carry :
                        false;
                },
                true
            )))()($values);
        };
    }
}
