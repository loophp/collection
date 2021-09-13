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
 * @param CollectionInterface<list<int>, list<int|string>> $collection
 */
function zip_checkIntString(CollectionInterface $collection): void
{
}

zip_checkIntString(Collection::fromIterable(range(1, 3))->zip(range('a', 'c')));

/**
 * @param CollectionInterface<list<bool|int>, list<bool|string>> $collection
 */
function zip_checkBoolString(CollectionInterface $collection): void
{
}

$generator =
    /**
     * @return Generator<bool, bool>
     */
    static function (): Generator {
        yield true => true;

        yield false => false;

        yield true => true;
    };

zip_checkBoolString(Collection::fromIterable($generator())->zip(range('a', 'c')));
