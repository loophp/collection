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
function random_checkIntList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, string> $collection
 */
function random_checkStringList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<int, bool> $collection
 */
function random_checkBoolList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, string> $collection
 */
function random_checkStringMap(CollectionInterface $collection): void
{
}

$intGenerator = static function (): Generator {
    while (true) {
        yield mt_rand();
    }
};

$boolGenerator = static function (): Generator {
    while (true) {
        yield (0 === mt_rand() % 2) ? true : false;
    }
};

$stringGenerator = static function (): Generator {
    while (true) {
        yield chr(random_int(0, 255));
    }
};

$stringStringGenerator = static function (): Generator {
    while (true) {
        yield chr(random_int(0, 255)) => chr(random_int(0, 255));
    }
};

random_checkIntList(Collection::fromIterable($intGenerator())->random());
random_checkStringList(Collection::fromIterable($stringGenerator())->random());
random_checkBoolList(Collection::fromIterable($boolGenerator())->random());
random_checkStringMap(Collection::fromIterable($stringStringGenerator())->random());
