<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use ArrayIterator;
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
final class Contains extends AbstractTransformation implements Transformation
{
    /**
     * @param mixed ...$values
     * @psalm-param T ...$values
     */
    public function __construct(...$values)
    {
        $this->storage['values'] = new ArrayIterator($values);
    }

    public function __invoke()
    {
        return static function (Iterator $collection, ArrayIterator $values): bool {
            return (new FoldLeft(
                static function (bool $carry, $item, $key) use ($collection) {
                    $hasCallback = static function ($k, $v) use ($item) {
                        return $item;
                    };

                    return ((new Transform(new Has($hasCallback)))($collection)) ?
                        $carry :
                        false;
                },
                true
            ))($values);
        };
    }
}
