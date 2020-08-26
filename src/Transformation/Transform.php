<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use Closure;
use Iterator;
use loophp\collection\Contract\Transformation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements Transformation<TKey, T>
 */
final class Transform implements Transformation
{
    /**
     * @psalm-param \Iterator<TKey, T> $collection
     *
     * @return mixed|null
     * @psalm-return T|scalar|null|\Iterator<TKey, T>
     */
    public function __invoke()
    {
        return static function (callable ...$transformers): Closure {
            return static function (Iterator $iterator) use ($transformers) {
                return (new FoldLeft())()(
                    static function (Iterator $collection, callable $transformer, $key) {
                        return $transformer($collection);
                    }
                )($iterator)($transformers);
            };
        };
    }
}
