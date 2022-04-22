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
 * @param CollectionInterface<list<bool>, list<bool>> $collection
 */
function zip_checkBoolBool(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<list<bool|int>, list<bool|string>> $collection
 */
function zip_checkBoolString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<list<int>, list<int|string>> $collection
 */
function zip_checkIntString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<list<bool|int>, list<bool|int|string>> $collection
 */
function zip_checkBoolStringInt(CollectionInterface $collection): void
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

// With one single parameter
zip_checkBoolBool(Collection::fromIterable($generator())->zip($generator()));
zip_checkBoolString(Collection::fromIterable($generator())->zip(range('a', 'c')));
zip_checkIntString(Collection::fromIterable(range(1, 3))->zip(range('a', 'c')));

// With two parameters of the same types
zip_checkBoolBool(Collection::fromIterable($generator())->zip($generator(), $generator()));

// With two parameters of different types
// Fails with PHPStan, not in PSalm.
zip_checkBoolStringInt(Collection::fromIterable($generator())->zip(range('a', 'c'), range(1, 3)));
