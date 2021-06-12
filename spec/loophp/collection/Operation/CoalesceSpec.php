<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Operation;

use ArrayIterator;
use loophp\collection\Operation\Coalesce;
use PhpSpec\ObjectBehavior;

class CoalesceSpec extends ObjectBehavior
{
    public function it_can_coalesce(): void
    {
        $input = range('a', 'e');

        $iterator = new ArrayIterator($input);

        $this
            ->__invoke()($iterator)
            ->shouldHaveCount(1);

        $this
            ->__invoke()($iterator)
            ->shouldIterateAs([
                0 => 'a',
            ]);

        $input = ['', null, 'foo', false, ...range('a', 'e')];

        $iterator = new ArrayIterator($input);

        $this
            ->__invoke()($iterator)
            ->shouldHaveCount(1);

        $this
            ->__invoke()($iterator)
            ->shouldIterateAs([
                2 => 'foo',
            ]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Coalesce::class);
    }
}
