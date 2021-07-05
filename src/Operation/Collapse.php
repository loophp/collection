<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\fpt\FPT;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Collapse extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, (T|iterable<TKey, T>)>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, iterable<TKey, T>|T> $iterator
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator): Generator {
                // TODO: Should we keep this?
                /** @var Closure(Iterator<TKey, T|iterable<TKey, T>>): Generator<TKey, iterable<TKey, T>> $filter */
                $filter = Filter::of()(
                    FPT::compose()(
                        'is_iterable',
                        FPT::arg()(0)
                    )
                );

                foreach ($filter($iterator) as $value) {
                    yield from $value;
                }
            };
    }
}
