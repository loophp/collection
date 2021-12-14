<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\collection\Utils;

use ArrayIterator;
use Iterator;
use loophp\collection\Utils\CallbacksArrayReducer;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversDefaultClass \loophp\collection\Utils
 */
final class CallbacksArrayReducerTest extends TestCase
{
    public function testEnsureCallbacksReceiveTheNeededArguments(): void
    {
        $callbacks = [
            static fn (string $value, string $key, Iterator $iterator): bool => 'value_key_a_b_c' === sprintf('%s_%s_%s', $value, $key, implode('_', iterator_to_array($iterator))),
        ];

        $iterator = new ArrayIterator(range('a', 'c'));

        self::assertTrue(CallbacksArrayReducer::or()($callbacks, 'value', 'key', $iterator));
    }

    public function testReducesEmptyCallbacksArray(): void
    {
        $iterator = new ArrayIterator(range(0, 10));

        self::assertFalse(CallbacksArrayReducer::or()([], 0, 0, $iterator));
    }

    public function testReducesMultipleCallbacks(): void
    {
        $callbacks = [
            static fn (int $v): bool => 5 < $v,
            static fn (int $v): bool => 0 === $v % 2,
        ];

        $iterator = new ArrayIterator(range(0, 10));

        self::assertTrue(CallbacksArrayReducer::or()($callbacks, 0, 0, $iterator));

        self::assertTrue(CallbacksArrayReducer::or()($callbacks, 13, 0, $iterator));

        self::assertFalse(CallbacksArrayReducer::or()($callbacks, 3, 0, $iterator));
    }

    public function testReducesSingleCallback(): void
    {
        $callbacks = [
            static fn (int $v): bool => 5 < $v,
        ];

        $iterator = new ArrayIterator(range(0, 10));

        self::assertFalse(CallbacksArrayReducer::or()($callbacks, 0, 0, $iterator));

        self::assertTrue(CallbacksArrayReducer::or()($callbacks, 6, 0, $iterator));
    }
}
