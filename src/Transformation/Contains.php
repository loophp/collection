<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use ArrayIterator;
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
final class Contains implements Transformation
{
    /**
     * @var ArrayIterator<int, mixed>
     * @psalm-var ArrayIterator<int, T>
     */
    private $values;

    /**
     * @param mixed ...$values
     * @psalm-param T ...$values
     */
    public function __construct(...$values)
    {
        $this->values = new ArrayIterator($values);
    }

    public function __invoke()
    {
        return static function (...$values): Closure {
            return static function (Iterator $iterator) use ($values): bool {
                foreach ($iterator as $key => $value) {
                    foreach ($values as $k => $v) {
                        if ($v === $value) {
                            unset($values[$k]);
                        }

                        if ([] === $values) {
                            return true;
                        }
                    }
                }

                return false;
            };
        };
    }
}
