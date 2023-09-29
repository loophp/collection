<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, int> $collection
 */
function column_checkInt(CollectionInterface $collection): void {}

/**
 * @param CollectionInterface<int, string> $collection
 */
function column_checkString(CollectionInterface $collection): void {}

$records = [
    [
        'id' => 2135,
        'first_name' => 'John',
        'last_name' => 'Doe',
    ],
    [
        'id' => 3245,
        'first_name' => 'Sally',
        'last_name' => 'Smith',
    ],
];
$nonArrayKeyRecords = [
    (static fn () => yield ['id'] => 1234)(),
    (static fn () => yield ['id'] => 5678)(),
];

column_checkInt(Collection::fromIterable($records)->column('id'));
column_checkInt(Collection::fromIterable($nonArrayKeyRecords)->column('id'));
column_checkInt(
    Collection::fromIterable($records)
        ->column('id')
        ->map(static fn (string $id): int => (int) $id)
);

column_checkString(Collection::fromIterable($records)->column('first_name'));
column_checkString(Collection::fromIterable($records)->column('middle_name'));

// Below are examples of usages that are technically incorrect but are allowed
// by static analysis because `column` needs to be flexible and cannot be properly typed

column_checkInt(Collection::fromIterable($records)->column(['first_name']));
column_checkString(Collection::fromIterable($nonArrayKeyRecords)->column('id'));
