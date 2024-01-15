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

    public function testIssue331(): void
    {
        $valueObjectFactory = static fn (int $id, int $weight) => new class($id, $weight) {
            public function __construct(
                public readonly int $id,
                public readonly int $weight,
            ) {}
        };

        $input = Collection::fromIterable([
            $valueObjectFactory(id: 1, weight: 1),
            $valueObjectFactory(id: 2, weight: 1),
            $valueObjectFactory(id: 3, weight: 1),
        ])
            ->sort(callback: static fn (object $a, object $b): int => $a->weight <=> $b->weight)
            ->map(static fn ($item): int => $item->id);

        self::assertEquals([1, 2, 3], $input->all());
    }
}
