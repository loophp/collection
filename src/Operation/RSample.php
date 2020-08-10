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
 *
 * @implements Operation<TKey, T>
 */
final class RSample extends AbstractGeneratorOperation implements Operation
{
    public function __construct(float $probability)
    {
        $this->storage['probability'] = $probability;
    }

    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-param \Iterator<TKey, T> $iterator
             *
             * @psalm-return \Generator<TKey, T>
             */
            static function (Iterator $iterator, float $probability): Generator {
                return yield from (new Run(
                    new Filter(
                        static function () use ($probability): bool {
                            return (mt_rand() / mt_getrandmax()) < $probability;
                        }
                    )
                ))()($iterator);
            };
    }
}
