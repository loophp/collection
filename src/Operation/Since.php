<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Since extends AbstractOperation implements Operation
{
    /**
     * @param callable ...$callbacks
     * @psalm-param callable(T, TKey):(bool) ...$callbacks
     */
    public function __construct(callable ...$callbacks)
    {
        $this->storage['callbacks'] = $callbacks;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             * @psalm-param list<callable(T, TKey):(bool)> $callbacks
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, array $callbacks): Generator {
                while ($iterator->valid()) {
                    $result = array_reduce(
                        $callbacks,
                        static function (bool $carry, callable $callable) use ($iterator): bool {
                            return ($callable($iterator->current(), $iterator->key())) ?
                                $carry :
                                false;
                        },
                        true
                    );

                    if (false !== $result) {
                        break;
                    }

                    $iterator->next();
                }

                for (; $iterator->valid(); $iterator->next()) {
                    yield $iterator->key() => $iterator->current();
                }
            };
    }
}
