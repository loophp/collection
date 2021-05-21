<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use loophp\collection\Collection;
use loophp\collection\Contract\Operation\Splitable;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1 -> Parse the composer.json of a package and get the require-dev dependencies.
/** @var resource $fileResource */
$fileResource = fopen(__DIR__ . '/composer.json', 'rb');
$collection = Collection::fromResource($fileResource)
    // Group items when EOL character is found.
    ->split(Splitable::REMOVE, static fn (string $character): bool => "\n" === $character)
    // Implode characters to create a line string
    ->map(static fn (array $characters): string => implode('', $characters))
    // Skip items until the string "require-dev" is found.
    ->since(static fn ($line): bool => false !== strpos($line, 'require-dev'))
    // Skip items after the string "}" is found.
    ->until(static fn ($line): bool => false !== strpos($line, '}'))
    // Re-index the keys
    ->normalize()
    // Filter out the first line and the last line.
    ->filter(
        static fn ($line, $index): bool => 0 !== $index,
        static fn ($line): bool => false === strpos($line, '}')
    )
    // Trim remaining results and explode the string on ':'.
    ->map(
        static fn ($line) => trim($line),
        static fn ($line) => explode(':', $line)
    )
    // Take the first item.
    ->pluck(0)
    // Convert to array.
    ->all();

// Example 2 -> Usage as logical OR and logical AND
$input = [1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 3];

$isGreaterThanThree = static fn (int $value): bool => 3 < $value;
$isGreaterThanEight = static fn (int $value): bool => 8 < $value;

$logicalORCollection = Collection::fromIterable($input)
    ->since($isGreaterThanThree, $isGreaterThanEight);
// [4, 5, 6, 7, 8, 9, 1, 2, 3]

$logicalANDCollection = Collection::fromIterable($input)
    ->since($isGreaterThanThree)
    ->since($isGreaterThanEight);
// [9, 1, 2, 3]
