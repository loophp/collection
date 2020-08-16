<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Closure;
use Iterator;
use loophp\collection\Contract\Transformation;
use StdClass;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Last implements Transformation
{
    /**
     * @var callable|Closure
     * @psalm-var callable(T, TKey):(bool)|\Closure(T, TKey):(bool)
     */
    private $callback;

    /**
     * @var mixed|null
     * @psalm-var T|null
     */
    private $default;

    /**
     * @param mixed|null $default
     *
     * @psalm-param \Closure(T, TKey):(bool)|callable(T, TKey):(bool)|null $callback
     * @psalm-param T|null $default
     */
    public function __construct(?callable $callback = null, $default = null)
    {
        $defaultCallback =
            /**
             * @param mixed $key
             * @param mixed $value
             *
             * @psalm-param TKey $key
             * @psalm-param T $value
             */
            static function ($key, $value): bool {
                return true;
            };

        $this->callback = $callback ?? $defaultCallback;
        $this->default = $default;
    }

    /**
     * @psalm-param Iterator<TKey, T> $collection
     *
     * @return mixed|null
     * @psalm-return T|null
     */
    public function __invoke(Iterator $collection)
    {
        $callback = $this->callback;
        $default = $this->default;
        $return = $nothing = new StdClass();

        foreach ($collection as $key => $value) {
            if (true === $callback($value, $key)) {
                $return = $value;
            }
        }

        return ($return !== $nothing) ?
            $return :
            $default;
    }
}
