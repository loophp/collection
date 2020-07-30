<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 *
 * @implements Transformation<TKey, T>
 */
final class Contains implements Transformation
{
    /**
     * @var mixed
     * @psalm-var T
     */
    private $value;

    /**
     * @param mixed $value
     * @psalm-param T $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param iterable<TKey, T> $collection
     *
     * @return bool
     */
    public function __invoke(iterable $collection)
    {
        $value = $this->value;

        $hasCallback =
            /**
             * @param mixed $k
             * @psalm-param TKey $k
             *
             * @param mixed $v
             * @psalm-param T $v
             *
             * @return mixed
             * @psalm-return T
             */
            static function ($k, $v) use ($value) {
                return $value;
            };

        return (bool) (new Transform(new Has($hasCallback)))($collection);
    }
}
