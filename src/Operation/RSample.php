<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * @template TKey
 * @psalm-template TKey of array-key
 * @template T
 * @extends AbstractOperation<TKey, T, \Generator<TKey, T>>
 * @implements Operation<TKey, T, \Generator<TKey, T>>
 */
final class RSample extends AbstractOperation implements Operation
{
    public function __construct(float $probability)
    {
        $this->storage['probability'] = $probability;
    }

    /**
     * @return Closure(\Iterator<TKey, T>, float):Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator, float $probability): Generator {
                return yield from (new Run(
                    new Filter(
                        static function ($value, $key) use ($probability): bool {
                            return (mt_rand() / mt_getrandmax()) < $probability;
                        }
                    )
                ))($iterator);
            };
    }
}
