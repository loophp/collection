<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function unpack_checkListInt(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<int, string> $collection
 */
function unpack_checkListString(CollectionInterface $collection): void
{
}

/**
 * @param CollectionInterface<string, string> $collection
 */
function unpack_checkListStringWithString(CollectionInterface $collection): void
{
}

$infiniteIntIntGenerator = static function (): Generator {
    yield [random_int(-10, 10), random_int(-10, 10)];
};

$infiniteIntStringGenerator = static function (): Generator {
    yield [random_int(-10, 10), chr(random_int(0, 255))];
};

$infiniteStringStringGenerator = static function (): Generator {
    yield [chr(random_int(0, 255)), chr(random_int(0, 255))];
};

unpack_checkListInt(Collection::fromIterable($infiniteIntIntGenerator())->unpack());
unpack_checkListString(Collection::fromIterable($infiniteIntStringGenerator())->unpack());
unpack_checkListStringWithString(Collection::fromIterable($infiniteStringStringGenerator())->unpack());
