<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use InvalidArgumentException;
use loophp\collection\Iterator\ResourceIterator;
use loophp\PhpUnitIterableAssertions\Traits\IterableAssertions;
use PHPUnit\Framework\TestCase;

use function is_resource;

/**
 * @internal
 * @coversDefaultClass \loophp\collection\Iterator
 */
final class ResourceIteratorTest extends TestCase
{
    use IterableAssertions;

    public function testCanIterate(): void
    {
        $iterator = new ResourceIterator(fopen('data://text/plain,ABC', 'rb'));

        self::assertIdenticalIterable(
            range('A', 'C'),
            $iterator
        );
    }

    public function testClosesOpenedFileIfNeeded(): void
    {
        $file = fopen(__DIR__ . '/../../fixtures/sample.txt', 'rb');
        $iterator = new ResourceIterator($file, true);

        self::assertIdenticalIterable(
            range('a', 'c'),
            $iterator
        );

        self::assertFalse(is_resource($file));
        self::assertIsResource($file);
    }

    public function testDoesNotAllowNonResource(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $iterator = new ResourceIterator(false);
    }

    public function testDoesNotAllowUnsupportedResource(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $iterator = new ResourceIterator(imagecreate(100, 100));
    }

    public function testDoesNotCloseResourceByDefault(): void
    {
        $file = fopen(__DIR__ . '/../../fixtures/sample.txt', 'rb');

        $iterator = new ResourceIterator($file);

        self::assertIdenticalIterable(
            range('a', 'c'),
            $iterator
        );

        self::assertTrue(is_resource($file));
        self::assertIsResource($file);
    }
}
