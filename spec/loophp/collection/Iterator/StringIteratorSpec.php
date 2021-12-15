<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use loophp\collection\Iterator\StringIterator;
use PhpSpec\ObjectBehavior;

class StringIteratorSpec extends ObjectBehavior
{
    public function it_can_iterate_with_default_delimiter(): void
    {
        $this->beConstructedWith('A string.');

        $this->shouldIterateAs(['A', ' ', 's', 't', 'r', 'i', 'n', 'g', '.']);
    }

    public function it_can_iterate_with_given_delimiter(): void
    {
        $this->beConstructedWith('I am a string.', ' ');

        $this->shouldIterateAs(['I', 'am', 'a', 'string.']);
    }

    public function it_is_initializable_with_default_delimiter(): void
    {
        $this->beConstructedWith('I am a string.');

        $this->shouldHaveType(StringIterator::class);
    }

    public function it_is_initializable_with_given_delimiter(): void
    {
        $this->beConstructedWith('I am a string.', ' ');

        $this->shouldHaveType(StringIterator::class);
    }
}
