<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Utils;

use ArrayIterator;
use Iterator;
use loophp\collection\Utils\CallbacksArrayReducer;
use PhpSpec\ObjectBehavior;

class CallbacksArrayReducerSpec extends ObjectBehavior
{
    public function it_ensure_callbacks_receive_the_needed_arguments(): void
    {
        $callbacks = [
            static fn (string $value, string $key, Iterator $iterator): bool => 'value_key_a_b_c' === sprintf('%s_%s_%s', $value, $key, implode('_', iterator_to_array($iterator))),
        ];

        $iterator = new ArrayIterator(range('a', 'c'));

        $this::or()($callbacks, 'value', 'key', $iterator)
            ->shouldReturn(true);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CallbacksArrayReducer::class);
    }

    public function it_reduces_empty_callbacks_array(): void
    {
        $iterator = new ArrayIterator(range(0, 10));

        $this::or()([], 0, 0, $iterator)
            ->shouldReturn(false);
    }

    public function it_reduces_multiple_callbacks(): void
    {
        $callbacks = [
            static fn (int $v): bool => 5 < $v,
            static fn (int $v): bool => 0 === $v % 2,
        ];

        $iterator = new ArrayIterator(range(0, 10));

        $this::or()($callbacks, 0, 0, $iterator)
            ->shouldReturn(true);

        $this::or()($callbacks, 13, 0, $iterator)
            ->shouldReturn(true);

        $this::or()($callbacks, 3, 0, $iterator)
            ->shouldReturn(false);
    }

    public function it_reduces_single_callback(): void
    {
        $callbacks = [
            static fn (int $v): bool => 5 < $v,
        ];

        $iterator = new ArrayIterator(range(0, 10));

        $this::or()($callbacks, 0, 0, $iterator)
            ->shouldReturn(false);

        $this::or()($callbacks, 6, 0, $iterator)
            ->shouldReturn(true);
    }
}
