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
use loophp\collection\Contract\Operation;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Head implements Operation
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
             * @param Iterator<TKey, T> $iterator
             *
             * @return Generator<TKey, T>
             */
            static function (Iterator $iterator): Generator {
                $isEmpty = true;

                foreach ($iterator as $key => $current) {
                    $isEmpty = false;

                    break;
                }

                if (false === $isEmpty) {
                    /**
                     * @var TKey $key
                     * @var T $current
                     */
                    return yield $key => $current;
                }
            };
    }

    /**
     * @pure
     */
    public static function of(): Closure
    {
        return (new self())->__invoke();
    }
}
