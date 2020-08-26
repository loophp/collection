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
final class FoldRight implements Transformation
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
                    $foldLeft = (new FoldLeft())()($callback)($initial);
                    $reverse = (new Reverse())();

                    return (new Transform())()($foldLeft)((new Run())()($reverse)($iterable));
                };
            };
        };
    }
}
