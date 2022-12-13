<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\CollectionDecorator;

final class FoobarCollection extends CollectionDecorator
{
    public function toUpperCase(): FoobarCollection
    {
        return $this
            ->map(
                static fn (string $letter): string => strtoupper($letter)
            );
    }
}

$collection = FoobarCollection::fromIterable(range('a', 'e'))
    ->toUpperCase();
