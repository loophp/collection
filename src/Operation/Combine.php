<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use ArrayIterator;
use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use const E_USER_WARNING;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Combine extends AbstractOperation implements Operation
{
    public function __invoke(): Closure
    {
        return static function (...$keys): Closure {
            return static function (Iterator $iterator) use ($keys): Generator {
                $keys = new ArrayIterator($keys);

                while ($iterator->valid() && $keys->valid()) {
                    yield $keys->current() => $iterator->current();

                    $iterator->next();
                    $keys->next();
                }

                if ($iterator->valid() !== $keys->valid()) {
                    trigger_error('Both keys and values must have the same amount of items.', E_USER_WARNING);
                }
            };
        };
    }
}
