<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Amp\Sync\LocalSemaphore;
use Closure;
use Exception;
use Generator;

use function Amp\Iterator\fromIterable;
use function Amp\ParallelFunctions\parallel;
use function Amp\Promise\wait;
use function Amp\Sync\ConcurrentIterator\map;
use function function_exists;

if (!function_exists('Amp\ParallelFunctions\parallel')) {
    throw new Exception('You need amphp/parallel-functions to get this operation working.');
}

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class AsyncMapN extends AbstractOperation
{
    /**
     * @return Closure(callable(mixed, mixed): mixed ...): Closure(iterable<TKey, T>): Generator<mixed, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(mixed, mixed): mixed ...$callbacks
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @param iterable<TKey, T> $iterable
                 *
                 * @return Generator<mixed, mixed>
                 */
                static function (iterable $iterable) use ($callbacks): Generator {
                    $callbackFactory =
                        /**
                         * @return Closure(mixed, callable(mixed, mixed): mixed): mixed
                         */
                        static fn (mixed $key): Closure =>
                            /**
                             * @param callable(mixed, mixed): mixed $callback
                             */
                            static fn (mixed $carry, callable $callback): mixed => $callback($carry, $key);

                    $callback =
                        /**
                         * @param array{0: mixed, 1: mixed} $value
                         *
                         * @return array{0: mixed, 1: mixed}
                         */
                        static fn (array $value): array => [$value[0], array_reduce($callbacks, $callbackFactory($value[0]), $value[1])];

                    $iter = map(fromIterable((new Pack())()($iterable)), new LocalSemaphore(32), parallel($callback));

                    while (wait($iter->advance())) {
                        /** @var array{0: mixed, 1: mixed} $item */
                        $item = $iter->getCurrent();

                        yield $item[0] => $item[1];
                    }
                };
    }
}
