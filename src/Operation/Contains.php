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
     * @param mixed ...$values
     * @psalm-param T ...$values
     */
    public function __construct(...$values)
    {
        $this->storage['values'] = new ArrayIterator($values);
    }

    public function __invoke(): Closure
    {
        return static function (Iterator $collection, ArrayIterator $values): bool {
            return (new Run())()($values, new FoldLeft(
                static function (bool $carry, $item, $key) use ($collection) {
                    $hasCallback = static function ($k, $v) use ($item) {
                        return $item;
                    };

                    return ((new Run()))()($collection, new Has($hasCallback)) ?
                        $carry :
                        false;
                },
                true
            ));
        };
    }
}
