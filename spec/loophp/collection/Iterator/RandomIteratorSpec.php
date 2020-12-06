<?php

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use ArrayIterator;
use Exception;
use loophp\collection\Iterator\RandomIterator;
use PhpSpec\ObjectBehavior;

class RandomIteratorSpec extends ObjectBehavior
{
    public function it_can_build_an_iterator_with_a_random_seed()
    {
        $input = new ArrayIterator(range('a', 'z'));
        $seed = 123;

        $this->beConstructedWith(
            $input,
            $seed
        );

        $expected = [
            2 => 'c',
            4 => 'e',
            22 => 'w',
            21 => 'v',
            20 => 'u',
            14 => 'o',
            5 => 'f',
            17 => 'r',
            25 => 'z',
            24 => 'y',
            10 => 'k',
            13 => 'n',
            23 => 'x',
            15 => 'p',
            8 => 'i',
            11 => 'l',
            0 => 'a',
            7 => 'h',
            19 => 't',
            9 => 'j',
            3 => 'd',
            16 => 'q',
            18 => 's',
            1 => 'b',
            12 => 'm',
            6 => 'g',
        ];

        if (iterator_to_array($this->getWrappedObject()) !== $expected) {
            throw new Exception('Iterator is not equal to the expected array.');
        }

        $iterator1 = new RandomIterator($input, $seed);
        $iterator2 = new RandomIterator($input, $seed + $seed);

        if (iterator_to_array($iterator1) === iterator_to_array($iterator2)) {
            throw new Exception('Iterator1 is equal to Iterator2');
        }
    }

    public function it_can_build_an_iterator_without_a_random_seed()
    {
        $input = new ArrayIterator(range('a', 'z'));
        $this->beConstructedWith($input);

        $iterator1 = new RandomIterator($input);

        if (iterator_to_array($iterator1) === iterator_to_array($this->getWrappedObject())) {
            throw new Exception('Iterator1 is equal to Iterator2');
        }
    }

    public function it_can_get_the_innerIterator()
    {
        $this->getInnerIterator()->shouldBeAnInstanceOf(ArrayIterator::class);
    }

    public function it_can_rewind()
    {
        $iterator = new ArrayIterator(['a']);

        $this->beConstructedWith($iterator, 1);

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

    public function it_is_initializable()
    {
        $this->shouldHaveType(RandomIterator::class);
    }

    public function let()
    {
        $iterator = new ArrayIterator(range('a', 'c'));

        $this->beConstructedWith($iterator, 1);
    }
}
