<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Amp\Emitter;
use Amp\Promise;
use Closure;
use Exception;
use Generator;
use Iterator;

use function Amp\ParallelFunctions\parallel;
use function Amp\Promise\all;
use function Amp\Promise\wait;
use function function_exists;

// phpcs:disable
if (false === function_exists('Amp\ParallelFunctions\parallel')) {
    throw new Exception('You need amphp/parallel to get this working.');
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
 * phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 */
final class AsyncMap extends AbstractOperation
{
    /**
     * @psalm-return Closure(callable(T, TKey): T): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param callable(T, TKey): T $callback
             *
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (callable $callback): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<TKey, T>
                 */
                static function (Iterator $iterator) use ($callback): Generator {
                    $emitter = new Emitter();
                    $iter = $emitter->iterate();
                    $callback = parallel($callback);

                    /** @psalm-var callable(Iterator<TKey, T>): Generator<TKey, T> $map */
                    $map = Map::of()(
                        /**
                         * @param mixed $value
                         * @psalm-param T $value
                         *
                         * @param mixed $key
                         * @psalm-param TKey $key
                         */
                        static function ($value, $key) use ($callback, $emitter): Promise {
                            $promise = $callback($value, $key);

                            $promise->onResolve(
                                /**
                                 * @param mixed $error
                                 * @psalm-param null|\Throwable $error
                                 *
                                 * @param mixed $value
                                 * @psalm-param T $value
                                 */
                                static function ($error, $value) use ($key, $emitter): ?Promise {
                                    if (null !== $error) {
                                        return $emitter->fail($error);
                                    }

                                    return $emitter->emit([$key, $value]);
                                }
                            );

                            return $promise;
                        }
                    );

                    all(iterator_to_array($map($iterator)))
                        ->onResolve(
                            static fn ($error) => !$error && $emitter->complete()
                        );

                    while (wait($iter->advance())) {
                        $item = $iter->getCurrent();

                        yield $item[0] => $item[1];
                    }
                };
    }
}
