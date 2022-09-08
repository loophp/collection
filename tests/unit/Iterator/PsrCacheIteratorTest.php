<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\collection\Iterator;

use ArrayIterator;
use loophp\collection\Iterator\PsrCacheIterator;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\CacheItem;

/**
 * @internal
 *
 * @coversDefaultClass \loophp\collection\Iterator
 */
final class PsrCacheIteratorTest extends TestCase
{
    public function testCacheData(): void
    {
        $cache = $this->createMock(CacheItemPoolInterface::class);
        $it = new ArrayIterator(range('a', 'e'));

        $iterator = new PsrCacheIterator($it, $cache);

        $cacheItem = new CacheItem();
        $cacheItem->set('a');

        $cache
            ->method('save', $cacheItem)
            ->willReturn(true);

        $cache
            ->method('getItem', 0)
            ->willReturn($cacheItem);

        $cache
            ->method('hasItem', 0)
            ->willReturn(true);

        $iterator->rewind();

        self::assertSame('a', $iterator->current());

        $iterator->rewind();

        self::assertSame('a', $iterator->current());

        $cacheItem = new CacheItem();
        $cacheItem->set('b');

        $cache
            ->method('save', $cacheItem)
            ->willReturn(true);

        $cache
            ->method('getItem', 1)
            ->willReturn($cacheItem);

        $cache
            ->method('hasItem', 1)
            ->willReturn(false);

        $iterator->next();

        self::assertSame('b', $iterator->current());
    }
}
