<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @phpstan-param CollectionInterface<int, string> $collection
 *
 * @psalm-param CollectionInterface<int<0,1>, 'bar'|'foo'> $collection
 */
function apply_checkList(CollectionInterface $collection): void {}
/**
 * @param CollectionInterface<string, string> $collection
 */
function apply_checkMap(CollectionInterface $collection): void {}

$echoCallbackTrue = static function (string $item): bool {
    echo $item;

    return true;
};
$echoCallbackFalse = static function (string $item): bool {
    echo $item;

    return false;
};

apply_checkList(Collection::fromIterable(['foo', 'bar'])->apply($echoCallbackTrue));
apply_checkList(Collection::fromIterable(['foo', 'bar'])->apply($echoCallbackFalse));
apply_checkList(Collection::fromIterable(['foo', 'bar'])->apply($echoCallbackTrue, $echoCallbackFalse));

$echoCallbackTrue = static function (string $item, string $key): bool {
    echo $item, $key;

    return true;
};
$echoCallbackFalse = static function (string $item, string $key): bool {
    echo $item, $key;

    return false;
};

apply_checkMap(Collection::fromIterable(['foo' => 'bar'])->apply($echoCallbackTrue));
apply_checkMap(Collection::fromIterable(['foo' => 'bar'])->apply($echoCallbackFalse));
apply_checkMap(Collection::fromIterable(['foo' => 'bar'])->apply($echoCallbackTrue, $echoCallbackFalse));
