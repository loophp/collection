<?php

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
    public function __construct(private string $name) {}

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
    ->duplicate(
        static fn (User $left): Closure => static fn (User $right): bool => $left->name() === $right->name()
    ); // [2 => User<foo>]

// Example 3 -> Using a custom accessor callback, with object values
final class Person
{
    public function __construct(private string $name) {}

    public function name(): string
    {
        return $this->name;
    }
}

$people = [
    new Person('foo'),
    new Person('bar'),
    new Person('foo'),
    new Person('a'),
];

$collection = Collection::fromIterable($people)
    ->duplicate(
        null,
        static fn (Person $person): string => $person->name()
    ); // [2 => Person<foo>]

// Example 4 -> Using both accessor and comparator callbacks, with object values
final class Cat
{
    public function __construct(private string $name) {}

    public function name(): string
    {
        return $this->name;
    }
}

$cats = [
    new Cat('izumi'),
    new Cat('nakano'),
    new Cat('booba'),
    new Cat('booba'),
];

$collection = Collection::fromIterable($cats)
    ->duplicate(
        static fn (string $left): Closure => static fn (string $right): bool => $left === $right,
        static fn (Cat $cat): string => $cat->name()
    ); // [3 => Cat<booba>]
