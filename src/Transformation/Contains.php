<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use ArrayIterator;
use Iterator;
use loophp\collection\Contract\Transformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Contains implements Transformation
{
    /**
     * @var ArrayIterator<int, mixed>
     * @psalm-var \ArrayIterator<int, T>
     */
    private $value;

    /**
     * @param mixed ...$value
     * @psalm-param T ...$value
     */
    public function __construct(...$value)
    {
        $this->value = new ArrayIterator($value);
    }

    /**
     * @param Iterator<TKey, T> $collection
     *
     * @return bool
     */
    public function __invoke(Iterator $collection)
    {
        $value = $this->value;

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
        ))($value);
    }
}
