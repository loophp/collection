<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\LazyOperation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 *
 * @implements LazyOperation<TKey, T>
 */
final class RSample extends AbstractLazyOperation implements LazyOperation
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
                return yield from (new Run())()(
                    $iterator,
                    new Filter(
                        static function () use ($probability): bool {
                            return (mt_rand() / mt_getrandmax()) < $probability;
                        }
                    )
                );
            };
    }
}
