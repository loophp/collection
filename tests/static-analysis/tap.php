<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @psalm-param CollectionInterface<int<0,1>, 'bar'|'foo'> $collection
 *
 * @phpstan-param CollectionInterface<int, string> $collection
 */
function tap_checkList(CollectionInterface $collection): void {}
/**
 * @param CollectionInterface<string, string> $collection
 */
function tap_checkMap(CollectionInterface $collection): void {}

$echoCallback = static function (string $item): void {
    echo $item;
};

tap_checkList(Collection::fromIterable(['foo', 'bar'])->tap($echoCallback));
tap_checkList(Collection::fromIterable(['foo', 'bar'])->tap($echoCallback, $echoCallback));

$echoCallback = static function (string $item, string $key): void {
    echo $item, $key;
};

tap_checkMap(Collection::fromIterable(['foo' => 'bar'])->tap($echoCallback));
tap_checkMap(Collection::fromIterable(['foo' => 'bar'])->tap($echoCallback, $echoCallback));
