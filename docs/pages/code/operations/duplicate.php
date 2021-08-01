<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use Closure;
use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1 -> Using the default callbacks, with scalar values
$collection = Collection::fromIterable(['a', 'b', 'a', 'c', 'a', 'c'])
    ->duplicate(); // [2 => 'a', 4 => 'a', 5 => 'c']

// Example 2 -> Using a custom comparator callback, with object values
final class User
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}

$users = [
    new User('foo'),
    new User('bar'),
    new User('foo'),
    new User('a'),
];

$collection = Collection::fromIterable($users)
    ->distinct(
        static fn (User $left): Closure => static fn (User $right): bool => $left->name() === $right->name()
    ); // [2 => User<foo>]

// Example 3 -> Using a custom accessor callback, with object values
final class Person
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}

$users = [
    new Person('foo'),
    new Person('bar'),
    new Person('foo'),
    new Person('a'),
];

$collection = Collection::fromIterable($users)
    ->distinct(
        null,
        static fn (Person $person): string => $person->name()
    ); // [2 => Person<foo>]

// Example 4 -> Using both accessor and comparator callbacks, with object values
final class Cat
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}

$users = [
    new Cat('izumi'),
    new Cat('nakano'),
    new Cat('booba'),
    new Cat('booba'),
];

$collection = Collection::fromIterable($users)
    ->distinct(
        static fn (string $left): Closure => static fn (string $right): bool => $left === $right,
        static fn (Cat $cat): string => $cat->name()
    ); // [3 => Cat<booba>]
