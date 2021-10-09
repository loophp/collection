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
final class IsEmpty implements Operation
{
    /**
     * @pure
     *
     * @return Closure(Iterator<TKey, T>): Generator<int, bool>
     */
    public function __invoke(): Closure
    {
        return static fn (Iterator $iterator): Generator => yield !$iterator->valid();
    }

    /**
     * @pure
     */
    public static function of(): Closure
    {
        return (new self())->__invoke();
    }
}
