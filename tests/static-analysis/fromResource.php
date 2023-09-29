<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, string> $collection
 */
function fromResource_check(CollectionInterface $collection): void {}

/** @var resource $resource */
$resource = fopen('https://loripsum.net/api', 'rb');
fromResource_check(Collection::fromResource($resource)->limit(25));
