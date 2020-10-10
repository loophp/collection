<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

$collection = Collection::fromIterable(['A', 'B', 'C', 'D', 'E']);

// Get the result as an array.
$collection
    ->all(); // ['A', 'B', 'C', 'D', 'E']

// Get the first item.
$collection
    ->first(); // ['a']

// Get the first item.
$collection
    ->first()
    ->current(); // 'a'

// Append items.
$collection
    ->append('F', 'G', 'H')
    ->normalize()
    ->all(); // ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H']

// Prepend items.
$collection
    ->prepend('1', '2', '3')
    ->normalize()
    ->all(); // ['1', '2', '3', 'A', 'B', 'C', 'D', 'E']

// Split a collection into chunks of a given size.
$collection
    ->chunk(2)
    ->all(); // [['A', 'B'], ['C', 'D'], ['E']]

// Merge items.
$collection
    ->merge([1, 2], [3, 4], [5, 6])
    ->all(); // ['A', 'B', 'C', 'D', 'E', 1, 2, 3, 4, 5, 6]

// Map data
$collection
    ->map(
        static function ($value, $key) {
            return sprintf('%s.%s', $value, $value);
        }
    )
    ->all(); // ['A.A', 'B.B', 'C.C', 'D.D', 'E.E']

// Use \StdClass as input
$data = (object) array_combine(range('A', 'E'), range('A', 'E'));

// Keys are preserved during the map() operation.
Collection::fromIterable(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'])
    ->map(
        static function (string $value, string $key): string {
            return mb_strtolower($value);
        }
    )
    ->all(); // ['A' => 'a', B => 'b', 'C' => 'c', 'D' = >'d', 'E' => 'e']

// Tail
Collection::fromIterable(range('a', 'z'))
    ->tail(3)
    ->all(); // [23 => 'x', 24 => 'y', 25 => 'z']

// Reverse
Collection::fromIterable(range('a', 'z'))
    ->tail(4)
    ->reverse()
    ->all(); // [25 => 'z', 24 => 'y', 23 => 'x', 22 => 'w']

// Flip operation.
// array_flip() can be used in PHP to remove duplicates from an array.(dedup-licate an array)
// See: https://www.php.net/manual/en/function.array-flip.php
// Example:
// $dedupArray = array_flip(array_flip(['a', 'b', 'c', 'd', 'a'])); // ['a', 'b', 'c', 'd']
// However, in loophp/collection it doesn't behave as such.
// As this library is based on PHP Generators, it's able to return multiple times the same key when iterating.
// You end up with the following result when issuing twice the ::flip() operation.
Collection::fromIterable(['a', 'b', 'c', 'd', 'a'])
    ->flip()
    ->flip()
    ->all(); // ['a', 'b', 'c', 'd', 'a']

// Get the Cartesian product.
Collection::fromIterable(['a', 'b'])
    ->product([1, 2])
    ->all(); // [['a', 1], ['a', 2], ['b', 1], ['b', 2]]

// Infinitely loop over numbers, cube them, filter those that are not divisible by 5, take the first 100 of them.
Collection::range(0, \INF)
    ->map(
        static function ($value, $key) {
            return $value ** 3;
        }
    )
    ->filter(
        static function ($value, $key) {
            return $value % 5;
        }
    )
    ->limit(100)
    ->all(); // [1, 8, 27, ..., 1815848, 1860867, 1906624]

// Apply a callback to the values without altering the original object.
// If the callback returns false, then it will stop.
Collection::fromIterable(range('A', 'Z'))
    ->apply(
        static function ($value, $key) {
            echo mb_strtolower($value);

            return true;
        }
    );

// Generate 300 distinct random numbers between 0 and 1000
$random = static function () {
    return mt_rand() / mt_getrandmax();
};

Collection::unfold($random)
    ->map(
        static function ($value) {
            return floor($value * 1000) + 1;
        }
    )
    ->distinct()
    ->limit(300)
    ->normalize()
    ->all();

// Fibonacci using the static method ::unfold()
$fibonacci = static function ($a = 0, $b = 1): array {
    return [$b, $b + $a];
};

Collection::unfold($fibonacci)
    // Get the first item of each result.
    ->pluck(0)
    // Limit the amount of results to 10.
    ->limit(10)
    // Convert to regular array.
    ->all(); // [0, 1, 1, 2, 3, 5, 8, 13, 21, 34, 55]

Collection::unfold($fibonacci)
    ->map(
        static function (array $value, $key) {
            return $value[1] / $value[0];
        }
    )
    ->limit(100)
    ->last(); // 1.6180339887499

// Use an existing Generator as input data.
$readFileLineByLine = static function (string $filepath): Generator {
    $fh = fopen($filepath, 'rb');

    while (false !== $line = fgets($fh)) {
        yield $line;
    }

    fclose($fh);
};

$hugeFile = __DIR__ . '/vendor/composer/autoload_static.php';

Collection::fromIterable($readFileLineByLine($hugeFile))
    // Add the line number at the end of the line, as comment.
    ->map(
        static function ($value, $key) {
            return str_replace(\PHP_EOL, ' // line ' . $key . \PHP_EOL, $value);
        }
    )
    // Find public static fields or methods among the results.
    ->filter(
        static function ($value, $key) {
            return false !== mb_strpos(trim($value), 'public static');
        }
    )
    // Drop the first result.
    ->drop(1)
    // Limit to 3 results only.
    ->limit(3)
    // Implode into a string.
    ->implode();

// Load a string
$string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
  Quisque feugiat tincidunt sodales.
  Donec ut laoreet lectus, quis mollis nisl.
  Aliquam maximus, orci vel placerat dapibus, libero erat aliquet nibh, nec imperdiet felis dui quis est.
  Vestibulum non ante sit amet neque tincidunt porta et sit amet neque.
  In a tempor ipsum. Duis scelerisque libero sit amet enim pretium pulvinar.
  Duis vitae lorem convallis, egestas mauris at, sollicitudin sem.
  Fusce molestie rutrum faucibus.';

// By default will have the same behavior as str_split().
Collection::fromString($string)
    ->explode(' ')
    ->count(); // 71

// Or add a separator if needed, same behavior as explode().
Collection::fromString($string, ',')
    ->count(); // 9

// Regular values normalization.
Collection::fromIterable([0, 2, 4, 6, 8, 10])
    ->scale(0, 10)
    ->all(); // [0, 0.2, 0.4, 0.6, 0.8, 1]

// Logarithmic values normalization.
Collection::fromIterable([0, 2, 4, 6, 8, 10])
    ->scale(0, 10, 5, 15, 3)
    ->all(); // [5, 8.01, 11.02, 12.78, 14.03, 15]

// Fun with function convergence.
// Iterator over the function: f(x) = r * x * (1-x)
// Change that parameter $r to see different behavior.
// More on this: https://en.wikipedia.org/wiki/Logistic_map
$function = static function ($x = .3, $r = 2) {
    return $r * $x * (1 - $x);
};

Collection::unfold($function)
    ->map(static function ($value) {
        return round($value, 2);
    })
    ->limit(10)
    ->all(); // [0.42, 0.48, 0.49, 0.49, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5]

// Infinitely loop over a collection
Collection::fromIterable(['A', 'B', 'C'])
    ->cycle();

// Traverse the collection using windows of a given size.
Collection::fromIterable(range('a', 'z'))
    ->window(3)
    ->all(); // [['a'], ['a', 'b'], ['a', 'b', 'c'], ['b', 'c', 'd'], ['c', 'd', 'e'], ...]

Collection::fromIterable(range('a', 'd'))
    ->wrap()
    ->all(); // [['a'], ['b'], ['c'], ['d']]

Collection::fromIterable([['a'], ['b'], ['c'], ['d']])
    ->unwrap()
    ->all(); // ['a', 'b', 'c', 'd']
