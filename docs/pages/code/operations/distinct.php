<?php

declare(strict_types=1);

namespace App;

use Closure;
use loophp\collection\Collection;

include __DIR__ . '/../../../../vendor/autoload.php';

// Example 1 -> Using the default callbacks, with scalar values
$collection = Collection::fromIterable(['a', 'b', 'a', 'c'])
    ->distinct(); // [0 => 'a', 1 => 'b', 3 => 'c']

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
    ); // [0 => User<foo>, 1 => User<bar>, 3 => User<a>]

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
    ); // [0 => Person<foo>, 1 => Person<bar>, 3 => Person<a>]

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
    ); // [0 => Cat<izumi>, 1 => Cat<nakano>, 2 => Cat<booba>]
