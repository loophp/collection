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
final class FoldLeft extends AbstractTransformation implements Transformation
{
    /**
     * @psalm-param callable(T|null, T, TKey, \Iterator<TKey, T>):(T|null) $callback
     *
     * @param mixed|null $initial
     * @psalm-param T|null $initial
     */
    public function __construct(callable $callback, $initial = null)
    {
        $this->storage['callback'] = $callback;
        $this->storage['initial'] = $initial;
    }

    public function __invoke()
    {
        return static function (Iterator $collection, callable $callback, $initial) {
            foreach ($collection as $key => $value) {
                $initial = $callback($initial, $value, $key, $collection);
            }

            return $initial;
        };
    }
}
