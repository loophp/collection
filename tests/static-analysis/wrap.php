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
 * @param CollectionInterface<int, array<int, int>> $collection
 */
function wrap_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, array<string, bool>> $collection
 */
function wrap_checkMap(CollectionInterface $collection): void
{
}

$intIntGenerator = static function (): Generator {
    yield mt_rand();
};

$stringBoolGenerator = static function (): Generator {
    yield chr(random_int(0, 255)) => 0 === mt_rand() % 2;
};

wrap_checkList(Collection::fromIterable($intIntGenerator())->wrap());
wrap_checkMap(Collection::fromIterable($stringBoolGenerator())->wrap());
