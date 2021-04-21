<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayAccess;
use ArrayIterator;
use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Collection;
use ReflectionClass;

use function array_key_exists;
use function in_array;
use function is_array;
use function is_object;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Pluck extends AbstractOperation
{
    /**
     * @psalm-return Closure(T):Closure(T):Closure(Iterator<TKey, T>):Generator<int, T|iterable<int, T>, mixed, void>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param mixed $key
             * @psalm-param T $key
             *
             * @psalm-return Closure(T): Closure(Iterator<TKey, T>): Generator<int, T|iterable<int, T>, mixed, void>
             */
            static fn ($key): Closure =>
                /**
                 * @param mixed $default
                 * @psalm-param T $default
                 *
                 * @psalm-return Closure(Iterator<TKey, T>): Generator<int, T|iterable<int, T>, mixed, void>
                 */
                static fn ($default): Closure =>
                    /**
                     * @psalm-param Iterator<TKey, T> $iterator
                     *
                     * @psalm-return Generator<int, T|iterable<int, T>, mixed, void>
                     */
                    static function (Iterator $iterator) use ($key, $default): Generator {
                        $pick =
                            /**
                             * @psalm-param Iterator<TKey, T> $iterator
                             *
                             * @param mixed $target
                             * @psalm-param T|iterable<TKey, T> $target
                             *
                             * @psalm-param array<int, string> $key
                             *
                             * @param mixed|null $default
                             * @psalm-param T $default
                             *
                             * @psalm-return T|iterable<int, T>
                             */
                            static function (Iterator $iterator, $target, array $key, $default = null) use (&$pick) {
                                while (null !== $segment = array_shift($key)) {
                                    if ('*' === $segment) {
                                        if (false === is_iterable($target)) {
                                            return $default;
                                        }

                                        /** @psalm-var array<int, T> $result */
                                        $result = [];

                                        foreach ($target as $item) {
                                            $result[] = $pick($iterator, $item, $key);
                                        }

                                        /** @psalm-var Generator<TKey, T> $collapse */
                                        $collapse = Collapse::of()(new ArrayIterator($result));

                                        return in_array('*', $key, true) ? $collapse : $result;
                                    }

                                    if ((true === is_array($target)) && (true === array_key_exists($segment, $target))) {
                                        /** @psalm-var T $target */
                                        $target = $target[$segment];
                                    } elseif (($target instanceof ArrayAccess) && (true === $target->offsetExists($segment))) {
                                        /** @psalm-var T $target */
                                        $target = $target[$segment];
                                    } elseif ($target instanceof Collection) {
                                        /** @psalm-var T $target */
                                        $target = (Get::of()($segment)($default)($target->getIterator()))->current();
                                    } elseif ((true === is_object($target)) && (true === property_exists($target, $segment))) {
                                        /** @psalm-var T $target */
                                        $target = (new ReflectionClass($target))->getProperty($segment)->getValue($target);
                                    } else {
                                        $target = $default;
                                    }
                                }

                                return $target;
                            };

                        $key = true === is_scalar($key) ? explode('.', trim((string) $key, '.')) : $key;

                        foreach ($iterator as $value) {
                            yield $pick($iterator, $value, $key, $default);
                        }
                    };
    }
}
