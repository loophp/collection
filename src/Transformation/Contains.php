<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

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
     * @param Iterator<TKey, T> $collection
     *
     * @return bool
     */
    public function __invoke(Iterator $collection)
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
