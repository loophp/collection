<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\collection\Iterator;

use loophp\collection\Iterator\StringIterator;
use loophp\PhpUnitIterableAssertions\Traits\IterableAssertions;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversDefaultClass \loophp\collection\Iterator
 */
final class StringIteratorTest extends TestCase
{
    use IterableAssertions;

    public function testIterateWithDefaultDelimiter(): void
    {
        $iterator = new StringIterator('A string.');

        self::assertIdenticalIterable(
            ['A', ' ', 's', 't', 'r', 'i', 'n', 'g', '.'],
            $iterator
        );
    }

    public function testIterateWithDelimiter(): void
    {
        $iterator = new StringIterator('I am a string.', ' ');

        self::assertIdenticalIterable(
            ['I', 'am', 'a', 'string.'],
            $iterator
        );
    }

    public function testWithUTF8String(): void
    {
        $iterator = new StringIterator('😃😁😂');

        self::assertIdenticalIterable(
            ['😃', '😁', '😂'],
            $iterator
        );
    }
}
