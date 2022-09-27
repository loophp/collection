<?php

declare(strict_types=1);

namespace App;

use Countable;
use loophp\collection\Collection;
use stdClass;

use function gettype;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1 -> allowed

Collection::fromIterable(range(1, 3))
    ->strict()
    ->all(); // [1, 2, 3]

// Example 2 -> allowed

$obj1 = new stdClass();
$obj2 = new stdClass();
$obj3 = null;

Collection::fromIterable([$obj1, $obj2, $obj3])
    ->strict()
    ->all(); // [$obj1, $obj2, $obj3]

// Example 3 -> allowed

$obj1 = new class() implements Countable {
    public function count(): int
    {
        return 0;
    }
};

$obj2 = new class() implements Countable {
    public function count(): int
    {
        return 0;
    }
};

Collection::fromIterable([$obj1, $obj2])
    ->strict()
    ->all(); // [$obj1, $obj2]

// Example 4 -> allowed

$arr1 = [1, 2, 3];
$arr2 = ['foo' => 'bar'];

Collection::fromIterable([$arr1, $arr2])
    ->strict()
    ->all(); // [$arr1, $arr2]

// Example 5 -> not allowed

Collection::fromIterable([1, 'foo', 3])
    ->strict()
    ->all(); // InvalidArgumentException

// Example 6 -> not alowed + custom callback

$obj1 = new class() implements Countable {
    public function count(): int
    {
        return 0;
    }
};

$obj2 = new class() {
    public function count(): int
    {
        return 0;
    }
};

Collection::fromIterable([$obj1, $obj2])
    ->strict()
    ->all(); // InvalidArgumentException

Collection::fromIterable([$obj1, $obj2])
    ->strict(static fn ($value): string => gettype($value))
    ->all(); // [$obj1, $obj2]
