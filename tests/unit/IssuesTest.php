<?php

declare(strict_types=1);

namespace tests\loophp\collection;

use loophp\collection\Collection;
use loophp\PhpUnitIterableAssertions\Traits\IterableAssertions;
use PHPUnit\Framework\TestCase;
use tests\loophp\collection\Traits\GenericCollectionProviders;

/**
 * @internal
 *
 * @coversDefaultClass \loophp\collection
 */
final class IssuesTest extends TestCase
{
    use GenericCollectionProviders;
    use IterableAssertions;

    public function testIssue264()
    {
        $subject = Collection::fromCallable(static function () {
            yield 100 => 'a';

            yield 200 => 'b';

            yield 300 => 'c';

            yield 400 => 'd';
        })->cache();

        self::assertEquals('a', $subject->get(100));
        self::assertEquals('b', $subject->get(200));
        self::assertEquals('c', $subject->get(300));
        self::assertEquals('d', $subject->get(400));
    }
}
