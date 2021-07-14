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

use function in_array;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Duplicate extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param Iterator<TKey, T> $iterable
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterable): Generator {
                $stack = [];

                foreach ($iterable as $key => $value) {
                    if (true === in_array($value, $stack, true)) {
                        yield $key => $value;
                    }

                    $stack[] = $value;
                }
            };
    }
}
