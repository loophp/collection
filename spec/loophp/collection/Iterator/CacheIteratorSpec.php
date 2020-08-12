<?php

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use Iterator;
use loophp\collection\Iterator\CacheIterator;
use PhpSpec\ObjectBehavior;
use Psr\Cache\CacheItemPoolInterface;

class CacheIteratorSpec extends ObjectBehavior
{
    public function it_can_get_the_inner_iterator(Iterator $iterator, CacheItemPoolInterface $cache)
    {
        $this
            ->beConstructedWith($iterator, $cache);

        $this
            ->getInnerIterator()
            ->shouldReturn($iterator);
    }

    public function it_is_initializable(Iterator $iterator, CacheItemPoolInterface $cache)
    {
        $this->beConstructedWith($iterator, $cache);
        $this->shouldHaveType(CacheIterator::class);
    }
}
