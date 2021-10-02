<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function associate_checkIntInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, int|string> $collection
 */
function associate_checkStringString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, bool|int> $collection
 */
function associate_checkStringBool(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, int> $collection
 */
function associate_checkStringInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, string> $collection
 */
function associate_checkIntString(CollectionInterface $collection): void
{
}

$intIntGenerator = static function (): Generator {
    while (true) {
        yield mt_rand();
    }
};

$StringStringGenerator = static function (): Generator {
    while (true) {
        yield chr(random_int(0, 255)) => chr(random_int(0, 255));
    }
};

$square = static fn (int $val): int => $val ** 2;
$toBoldString = static fn (int $val): string => sprintf('*%s*', $val);
$isEven = static fn (int $val): bool => 0 === $val % 2;
$stringToInt = static fn (string $value): int => (int) $value;

associate_checkIntInt(Collection::fromIterable($intIntGenerator())->associate($square, $square));
associate_checkStringString(Collection::fromIterable($intIntGenerator())->associate($toBoldString, $toBoldString));
associate_checkStringBool(Collection::fromIterable($intIntGenerator())->associate($toBoldString, $isEven));

// With the second callback missing
associate_checkStringInt(Collection::fromIterable($intIntGenerator())->associate($toBoldString));
associate_checkIntString(Collection::fromIterable($StringStringGenerator())->associate($stringToInt));
