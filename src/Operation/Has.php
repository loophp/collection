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
final class Has extends AbstractEagerOperation implements EagerOperation
{
    /**
     * @psalm-param callable(TKey, T):(T) $callback
     */
    public function __construct(callable $callback)
    {
        $this->storage['callback'] = $callback;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $collection
             * @psalm-param callable(TKey, T):(T) $callback
             */
            static function (Iterator $collection, callable $callback): bool {
                foreach ($collection as $key => $value) {
                    if ($callback($key, $value) === $value) {
                        return true;
                    }
                }

                return false;
            };
    }
}
