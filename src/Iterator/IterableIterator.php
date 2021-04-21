<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;

/**
 * @internal
 *
 * @psalm-template TKey
 * @psalm-template T
 *
 * @extends ProxyIterator<TKey, T>
 */
final class IterableIterator extends ProxyIterator
{
    /**
     * @param iterable<mixed> $iterable
     * @psalm-param iterable<TKey, T> $iterable
     */
    public function __construct(iterable $iterable)
    {
        $this->iterator = new ClosureIterator(
            /**
             * @psalm-param iterable<TKey, T> $iterable
             */
            static function (iterable $iterable): Generator {
                foreach ($iterable as $key => $value) {
                    yield $key => $value;
                }
            },
            $iterable
        );
    }
}
