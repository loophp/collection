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

// Example 1 -> Using the default callback, with scalar values
$collection = Collection::fromIterable(['a', 'b', 'a', 'c'])
    ->distinct(); // [0 => 'a', 1 => 'b', 3 => 'c']

// Example 2 -> Using one custom callback, with object values
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

// Example 3 -> Using two custom callbacks, with object values
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
        static fn (Cat $cat) => $cat->name()
    ); // [0 => Cat<izumi>, 1 => Cat<nakano>, 2 => Cat<booba>]
