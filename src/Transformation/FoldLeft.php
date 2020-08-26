<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Closure;
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
     * @psalm-param \Iterator<TKey, T> $collection
     *
     * @return mixed|null
     * @psalm-return T|null
     */
    public function __invoke()
    {
        return static function (callable $callback): Closure {
            return static function ($initial = null) use ($callback): Closure {
                return static function (iterable $iterable) use ($callback, $initial) {
                    foreach ($iterable as $key => $value) {
                        $initial = $callback($initial, $value, $key, $iterable);
                    }

                    return $initial;
                };
            };
        };
    }
}
