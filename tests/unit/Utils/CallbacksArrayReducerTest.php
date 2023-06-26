<?php

declare(strict_types=1);

namespace tests\loophp\collection\Utils;

use loophp\collection\Utils\CallbacksArrayReducer;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversDefaultClass \loophp\collection\Utils\CallbacksArrayReducer
 */
final class CallbacksArrayReducerTest extends TestCase
{
    public static function provideGenericCases()
    {
        // Ensure Callbacks receive the needed arguments.
        yield [
            [
                static fn (string $value, string $key, iterable $iterable): bool => 'value_key_a_b_c' === sprintf('%s_%s_%s', $value, $key, implode('_', $iterable)),
            ],
            'value',
            'key',
            range('a', 'c'),
            true,
        ];

        // Reduce empty callbacks array
        yield [
            [],
            0,
            0,
            range('a', 'c'),
            false,
        ];

        // Reduce multiple callbacks
        yield [
            [
                static fn (int $v): bool => 5 < $v,
                static fn (int $v): bool => 0 === $v % 2,
            ],
            0,
            0,
            range(0, 10),
            true,
        ];

        yield [
            [
                static fn (int $v): bool => 5 < $v,
                static fn (int $v): bool => 0 === $v % 2,
            ],
            13,
            0,
            range(0, 10),
            true,
        ];

        yield [
            [
                static fn (int $v): bool => 5 < $v,
                static fn (int $v): bool => 0 === $v % 2,
            ],
            3,
            0,
            range(0, 10),
            false,
        ];

        // Reduce single callback
        yield [
            [
                static fn (int $v): bool => 5 < $v,
            ],
            0,
            0,
            range(0, 10),
            false,
        ];

        yield [
            [
                static fn (int $v): bool => 5 < $v,
            ],
            6,
            0,
            range(0, 10),
            true,
        ];

        yield [
            [
                static fn (): bool => false,
            ],
            [],
            [],
            [],
            false,
        ];
    }

    /**
     * @dataProvider provideGenericCases
     */
    public function testGeneric(
        array $callbacks,
        mixed $current,
        mixed $key,
        array $iterator,
        bool $expected
    ): void {
        self::assertSame($expected, CallbacksArrayReducer::or()($callbacks)($current, $key, $iterator));
    }
}
