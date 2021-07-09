<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Utils;

use ArrayIterator;
use loophp\collection\Utils\CallbacksArrayReducer;
use PhpSpec\ObjectBehavior;

class CallbacksArrayReducerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CallbacksArrayReducer::class);
    }

    public function it_reduce_callbacks(): void
    {
        $callbacks = [
            static fn (int $v): bool => 5 < $v,
            static fn (int $v): bool => 0 === $v % 2,
        ];

        $input = range(0, 10);

        $iterator = new ArrayIterator($input);

        $this::or()($callbacks, 0, 0, $iterator)
            ->shouldReturn(true);

        $this::or()($callbacks, 13, 0, $iterator)
            ->shouldReturn(true);

        $this::or()($callbacks, 3, 0, $iterator)
            ->shouldReturn(false);
    }
}
