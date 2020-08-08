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
final class FoldLeft extends AbstractOperation implements Operation
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

    public function __invoke(): Closure
    {
        return static function (Iterator $collection, callable $callback, $initial) {
            foreach ($collection as $key => $value) {
                $initial = $callback($initial, $value, $key, $collection);
            }

            return $initial;
        };
    }
}
