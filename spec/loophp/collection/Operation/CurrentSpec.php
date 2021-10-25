<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Operation;

use ArrayIterator;
use loophp\collection\Operation\Current;
use PhpSpec\ObjectBehavior;

class CurrentSpec extends ObjectBehavior
{
    public function it_can_get_current(): void
    {
        $input = range('a', 'e');

        $iterator = new ArrayIterator($input);

        $this
            ->__invoke()(0)(null)($iterator)
            ->shouldIterateAs(['a']);

        $this
            ->__invoke()(0)(null)($iterator)
            ->shouldHaveCount(1);

        $this
            ->__invoke()(10)('unavailable')($iterator)
            ->shouldIterateAs(['unavailable']);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Current::class);
    }
}
