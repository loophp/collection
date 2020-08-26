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
    public function __invoke(): Closure
    {
        return static function (callable ...$callbacks): Closure {
            return static function (Iterator $iterator) use ($callbacks): Generator {
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
        };
    }
}
