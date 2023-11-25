<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

$stringGenerator = static function (): Generator {
    yield chr(random_int(0, 255));
};

/**
 * @param iterable<string, int> $iterable
 */
function checkStringInt(iterable $iterable): void {}

/**
 * @param iterable<int, string> $iterable
 */
function checkIntString(iterable $iterable): void {}

checkStringInt(
    Collection::fromCallable($stringGenerator)
        ->associate(
            static fn (int $key): int => $key,
            static fn (string $item): string => $item,
        )
        ->flip()
);

checkStringInt(
    Collection::fromCallable($stringGenerator)
        ->associate(
            static fn (int $key): int => $key,
            static fn (string $item): string => $item,
        )
        ->flip()
        ->all(false)
);

checkIntString(
    Collection::fromCallable($stringGenerator)
        ->associate(
            static fn (int $_, string $item): string => $item,
            static fn (string $_, int $key): int => $key,
        )
        ->flip()
);

checkIntString(
    Collection::fromCallable($stringGenerator)
        ->associate(
            static fn (int $_, string $item): string => $item,
            static fn (string $_, int $key): int => $key,
        )
        ->flip()
        ->all(false)
);
