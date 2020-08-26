<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayAccess;
use ArrayIterator;
use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Collection;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;
use loophp\collection\Transformation\Get;
use loophp\collection\Transformation\Run;
use loophp\collection\Transformation\Transform;
use ReflectionClass;

use function array_key_exists;
use function in_array;
use function is_array;
use function is_object;

final class Pluck extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function ($key): Closure {
            return static function ($default) use ($key): Closure {
                return static function (Iterator $iterator) use ($key, $default): Generator {
                    $pick = static function (Iterator $iterator, $target, array $key, $default = null) use (&$pick) {
                        while (null !== $segment = array_shift($key)) {
                            if ('*' === $segment) {
                                if (false === is_iterable($target)) {
                                    return $default;
                                }

                                $result = [];

                                foreach ($target as $item) {
                                    $result[] = $pick($iterator, $item, $key);
                                }

                                $collapse = (new Collapse())();

                                return in_array('*', $key, true) ? (new Run())()($collapse)(new ArrayIterator($result)) : $result;
                            }

                            if ((true === is_array($target)) && (true === array_key_exists($segment, $target))) {
                                $target = $target[$segment];
                            } elseif (($target instanceof ArrayAccess) && (true === $target->offsetExists($segment))) {
                                $target = $target[$segment];
                            } elseif ($target instanceof Collection) {
                                $get = (new Get())()($segment)($default);
                                $target = (new Transform())()($get)(new IterableIterator($target));
                            } elseif ((true === is_object($target)) && (true === property_exists($target, $segment))) {
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
            };
        };
    }
}
