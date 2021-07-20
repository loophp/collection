<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

$concat = static fn (string $carry, string $string): string => sprintf('%s%s', $carry, $string);
$toString =
    /**
     * @param int|string $carry
     */
    static fn ($carry, int $value): string => sprintf('%s', $value);

/**
 * @param CollectionInterface<int, string> $collection
 */
function scanRight1_checkListString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, int|string> $collection
 */
function scanRight1_checkListOfSize1String(CollectionInterface $collection): void
{
}

// see Psalm bug: https://github.com/vimeo/psalm/issues/6108
scanRight1_checkListString(Collection::fromIterable(range('a', 'c'))->scanRight1($concat));
scanRight1_checkListOfSize1String(Collection::fromIterable([10])->scanRight1($toString));
