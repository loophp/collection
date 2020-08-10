<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

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
final class First extends AbstractOperation implements Operation
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

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $collection
             * @psalm-param callable(T, TKey):(bool) $callback
             * @psalm-param T|null $initial
             *
             * @param mixed $default
             */
            static function (Iterator $collection, callable $callback, $default) {
                foreach ($collection as $key => $value) {
                    if (true === $callback($value, $key)) {
                        return $value;
                    }
                }

                return $default;
            };
    }
}
