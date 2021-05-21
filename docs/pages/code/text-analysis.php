<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

/** @var string $contents */
$contents = file_get_contents('https://loripsum.net/api');

$collection = Collection::fromString($contents)
    // Filter out some characters.
    ->filter(static fn ($item): bool => (bool) preg_match('/^[a-zA-Z]+$/', $item))
    // Lowercase each character.
    ->map(static fn (string $letter): string => mb_strtolower($letter))
    // Run the frequency tool.
    ->frequency()
    // Flip keys and values.
    ->flip()
    // Sort values.
    ->sort()
    // Convert to array.
    ->all();

print_r($collection);
