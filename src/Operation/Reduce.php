<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;
use loophp\collection\Contract\EagerOperation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements EagerOperation<TKey, T>
 */
final class Reduce extends AbstractEagerOperation implements EagerOperation
{
    /**
     * @psalm-param callable(T|null, T|null, TKey):(T|null) $callback
     *
     * @param mixed|null $initial
     * @psalm-param T|null $initial
     */
    public function __construct(callable $callback, $initial = null)
    {
        $this->storage['callback'] = $callback;
        $this->storage['initial'] = $initial;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $collection
             * @psalm-param callable(T|scalar|null, T|null, TKey):(T|scalar|null) $callback
             * @psalm-param T|scalar|null $initial
             *
             * @psalm-return T|scalar|null
             *
             * @param mixed $initial
             */
            static function (Iterator $collection, callable $callback, $initial) {
                return (new Run())()($collection, new FoldLeft($callback, $initial));
            };
    }
}
