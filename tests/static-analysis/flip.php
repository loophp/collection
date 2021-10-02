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
function flip_checkIntInt(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, string> $collection
 */
function flip_checkIntString(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, int> $collection
 */
function flip_checkStringInt(CollectionInterface $collection): void
{
}

$intIntGenerator = static function (): Generator {
    while (true) {
        yield mt_rand();
    }
};

$intStringGenerator = static function (): Generator {
    while (true) {
        yield chr(random_int(0, 255));
    }
};

flip_checkIntInt(Collection::fromIterable($intIntGenerator())->flip());
flip_checkStringInt(Collection::fromIterable($intStringGenerator())->flip());
flip_checkIntString(Collection::fromIterable($intStringGenerator())->flip()->flip());
