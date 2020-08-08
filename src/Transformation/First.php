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
final class First extends AbstractTransformation implements Transformation
{
    /**
     * @psalm-param callable(T, TKey):(bool)|null $callback
     *
     * @param mixed|null $default
     * @psalm-param T|null $default
     */
    public function __construct(?callable $callback = null, $default = null)
    {
        $defaultCallback =
            /**
             * @param mixed $key
             * @psalm-param TKey $key
             *
             * @param mixed $value
             * @psalm-param T $value
             */
            static function ($key, $value): bool {
                return true;
            };

        $this->storage['callback'] = $callback ?? $defaultCallback;
        $this->storage['default'] = $default;
    }

    public function __invoke()
    {
        return static function (Iterator $collection, callable $callback, $default) {
            foreach ($collection as $key => $value) {
                if (true === $callback($value, $key)) {
                    return $value;
                }
            }

            return $default;
        };
    }
}
