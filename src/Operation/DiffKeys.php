<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

use function in_array;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class DiffKeys extends AbstractOperation implements Operation
{
    /**
     * @param mixed ...$values
     * @psalm-param TKey ...$values
     */
    public function __construct(...$values)
    {
        $this->storage['values'] = $values;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param Iterator<TKey, T> $iterator
             * @psalm-param list<TKey> $values
             *
             * @psalm-return Generator<TKey, T>
             *
             * @param mixed $values
             */
            static function (Iterator $iterator, array $values): Generator {
                foreach ($iterator as $key => $value) {
                    if (false === in_array($key, $values, true)) {
                        yield $key => $value;
                    }
                }
            };
    }
}
