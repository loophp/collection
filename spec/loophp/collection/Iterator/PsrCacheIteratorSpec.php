<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use ArrayIterator;
use Iterator;
use loophp\collection\Iterator\PsrCacheIterator;
use PhpSpec\ObjectBehavior;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\CacheItem;

class PsrCacheIteratorSpec extends ObjectBehavior
{
    public function it_can_cache_data(CacheItemPoolInterface $cache): void
    {
        $it = new ArrayIterator(range('a', 'e'));

        $this->beConstructedWith($it, $cache);

        $cacheItem = new CacheItem();
        $cacheItem->set('a');

        $cache
            ->save($cacheItem)
            ->willReturn(true);

        $cache
            ->getItem(0)
            ->willReturn($cacheItem);

        $cache
            ->hasItem(0)
            ->willReturn(true);

        $this->rewind();

        $this
            ->current()
            ->shouldReturn('a');

        $cache
            ->getItem(0)
            ->shouldHaveBeenCalledOnce();
        $this->rewind();

        $this
            ->current()
            ->shouldReturn('a');

        $cacheItem = new CacheItem();
        $cacheItem->set('b');

        $cache
            ->save($cacheItem)
            ->willReturn(true);

        $cache
            ->getItem(1)
            ->willReturn($cacheItem);

        $cache
            ->hasItem(1)
            ->willReturn(false);

        $this->next();

        $this
            ->current()
            ->shouldReturn('b');

        $cache
            ->save($cacheItem)
            ->shouldHaveBeenCalledOnce();
    }

    public function it_is_initializable(Iterator $iterator, CacheItemPoolInterface $cache): void
    {
        $this->beConstructedWith($iterator, $cache);
        $this->shouldHaveType(PsrCacheIterator::class);
    }
}
