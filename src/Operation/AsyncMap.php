<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Amp\Sync\LocalSemaphore;
use Closure;
use Exception;
use Generator;
use Iterator;

use function Amp\Iterator\fromIterable;
use function Amp\ParallelFunctions\parallel;
use function Amp\Promise\wait;
use function Amp\Sync\ConcurrentIterator\map;
use function function_exists;

// phpcs:disable
if (false === function_exists('Amp\ParallelFunctions\parallel')) {
    throw new Exception('You need amphp/parallel-functions to get this operation working.');
}
// phpcs:enable
/**
 * Class AsyncMap.
 *
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class AsyncMap extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T, TKey): T ...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey): T ...$callbacks
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (callable ...$callbacks): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<TKey, T>
                 */
                static function (Iterator $iterator) use ($callbacks): Generator {
                    $callbackFactory =
                        /**
                         * @param mixed $key
                         * @psalm-param TKey $key
                         *
                         * @psalm-return Closure(T, callable(T, TKey): T): T
                         */
                        static fn ($key): Closure =>
                            /**
                             * @param mixed $carry
                             * @psalm-param T $carry
                             * @psalm-param callable(T, TKey): T $callback
                             *
                             * @psalm-return T
                             */
                            static fn ($carry, callable $callback) => $callback($carry, $key);

                    $callback =
                        /**
                         * @psalm-param array{0: TKey, 1:T} $value
                         *
                         * @psalm-return array{0: TKey, 1: T}
                         */
                        static function (array $value) use ($callbacks, $callbackFactory): array {
                            [$key, $value] = $value;

                            return [$key, array_reduce($callbacks, $callbackFactory($key), $value)];
                        };

                    $iter = map(fromIterable(Pack::of()($iterator)), new LocalSemaphore(32), parallel($callback));

                    while (wait($iter->advance())) {
                        /** @psalm-var array{0: TKey, 1: T} $item */
                        $item = $iter->getCurrent();

                        yield $item[0] => $item[1];
                    }
                };
    }
}
