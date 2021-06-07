<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use ArrayIterator;
use BadMethodCallException;
use loophp\collection\Iterator\RandomIterator;
use PhpSpec\Exception\Example\MatcherException;
use PhpSpec\ObjectBehavior;

class RandomIteratorSpec extends ObjectBehavior
{
    public function it_can_build_an_iterator_with_a_random_seed(): void
    {
        $input = new ArrayIterator(range('a', 'z'));
        $seed = 123;

        $this->beConstructedWith(
            $input,
            $seed
        );

        $expected = [
            2 => 'c',
            20 => 'u',
            8 => 'i',
            3 => 'd',
            7 => 'h',
            9 => 'j',
            0 => 'a',
            21 => 'v',
            12 => 'm',
            15 => 'p',
            13 => 'n',
            4 => 'e',
            19 => 't',
            10 => 'k',
            22 => 'w',
            11 => 'l',
            1 => 'b',
            5 => 'f',
            18 => 's',
            23 => 'x',
            17 => 'r',
            24 => 'y',
            16 => 'q',
            25 => 'z',
            14 => 'o',
            6 => 'g',
        ];

        if (iterator_to_array($this->getWrappedObject()) !== $expected) {
            throw new MatcherException('Iterator is not equal to the expected array.');
        }

        $iterator1 = new RandomIterator(new ArrayIterator(range('a', 'z')), $seed);
        $iterator2 = new RandomIterator(new ArrayIterator(range('a', 'z')), $seed + $seed);

        if (iterator_to_array($iterator1) === iterator_to_array($iterator2)) {
            throw new MatcherException('Iterator1 is equal to Iterator2');
        }
    }

    public function it_can_build_an_iterator_without_a_random_seed(): void
    {
        $input = new ArrayIterator(range('a', 'z'));
        $this->beConstructedWith($input);

        $iterator1 = new RandomIterator(new ArrayIterator(range('a', 'z')));

        if (iterator_to_array($iterator1) === iterator_to_array($this->getWrappedObject())) {
            throw new MatcherException('Iterator1 is equal to Iterator2');
        }
    }

    public function it_can_get_current(): void
    {
        $this->beConstructedWith(new ArrayIterator(['a']));
        $this->valid()->shouldReturn(false);
        $this->shouldThrow(BadMethodCallException::class)->during('current');

        $this->rewind();

        $this->valid()->shouldReturn(true);
        $this->current()->shouldReturn('a');
    }

    public function it_can_get_key(): void
    {
        $this->beConstructedWith(new ArrayIterator(['a' => 1]));
        $this->valid()->shouldReturn(false);
        $this->shouldThrow(BadMethodCallException::class)->during('key');

        $this->rewind();

        $this->valid()->shouldReturn(true);
        $this->key()->shouldReturn('a');
    }

    public function it_can_get_the_innerIterator(): void
    {
        $this->getInnerIterator()->shouldBeAnInstanceOf(ArrayIterator::class);
    }

    public function it_can_rewind(): void
    {
        $iterator = new ArrayIterator(['a']);

        $this->beConstructedWith($iterator, 1);

        $this
            ->valid()
            ->shouldReturn(false);

        $this->rewind();

        $this
            ->valid()
            ->shouldReturn(true);

        $this
            ->current()
            ->shouldReturn('a');

        $this->next();

        $this
            ->valid()
            ->shouldReturn(false);

        $this
            ->rewind();

        $this
            ->valid()
            ->shouldReturn(true);

        $this
            ->current()
            ->shouldReturn('a');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(RandomIterator::class);
    }

    public function let(): void
    {
        $iterator = new ArrayIterator(range('a', 'c'));

        $this->beConstructedWith($iterator, 1);
    }
}
