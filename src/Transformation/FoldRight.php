<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Closure;
use loophp\collection\Contract\Transformation;
use loophp\collection\Operation\Reverse;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class FoldRight extends AbstractTransformation implements Transformation
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
                    // @todo: Unify this when operation and transformation are the same.
                    return Transform::of()(FoldLeft::of()($callback)($initial))(Run::of()(Reverse::of())($iterable));
                };
            };
        };
    }
}
