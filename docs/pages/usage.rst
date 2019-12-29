Usage
=====

.. code-block:: php

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use drupol\collection\Collection;

    // More examples...
    $collection = Collection::with(['A', 'B', 'C', 'D', 'E']);

    // Get the result as an array.
    $collection
        ->all(); // ['A', 'B', 'C', 'D', 'E']

    // Get the first item.
    $collection
        ->first(); // A

    // Append items.
    $collection
        ->append('F', 'G', 'H')
        ->all(); // ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H']

    // Prepend items.
    $collection
        ->prepend('1', '2', '3')
        ->all(); // ['1', '2', '3', 'A', 'B', 'C', 'D', 'E']

    // Split a collection into chunks of a given size.
    $collection
        ->chunk(2)
        ->map(static function (Collection $collection) {return $collection->all();})
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

    // ::map() and ::walk() are not the same.
    Collection::with(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'])
        ->map(
            static function ($value, $key) {
                return strtolower($value);
            }
        )
        ->all(); // [0 => 'a', 1 => 'b', 2 => 'c', 3 = >'d', 4 => 'e']

    Collection::with(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'])
        ->walk(
            static function ($value, $key) {
                return strtolower($value);
            }
        )
        ->all(); // ['A' => 'a', B => 'b', 'C' => 'c', 'D' = >'d', 'E' => 'e']

    // Tail
    Collection::with(range('a', 'z'))
        ->tail(3)
        ->all(); // [23 => 'x', 24 => 'y', 25 => 'z']

    // Reverse
    Collection::with(range('a', 'z'))
        ->tail(4)
        ->reverse()
        ->all(); // [25 => 'z', 24 => 'y', 23 => 'x', 22 => 'w']

    // Flip operation.
    // array_flip() can be used in PHP to remove duplicates from an array.(dedup-licate an array)
    // See: https://www.php.net/manual/en/function.array-flip.php
    // Example:
    // $dedupArray = array_flip(array_flip(['a', 'b', 'c', 'd', 'a'])); // ['a', 'b', 'c', 'd']
    // However, in drupol/collection it doesn't behave as such.
    // As this library is based on PHP Generators, it's able to return multiple times the same key when iterating.
    // You end up with the following result when issuing twice the ::flip() operation.
    Collection::with(['a', 'b', 'c', 'd', 'a'])
        ->flip()
        ->flip()
        ->all(); // ['a', 'b', 'c', 'd', 'a']

    // Infinitely loop over numbers, cube them, filter those that are not divisible by 5, take the first 100 of them.
    Collection::range(0, INF)
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
    Collection::with(range('A', 'Z'))
        ->apply(
            static function ($value, $key) {
                echo strtolower($value);
            }
        );

    // Generate 300 distinct random numbers between 0 and 1000
    $random = static function() {
        return mt_rand() / mt_getrandmax();
    };

    Collection::iterate($random)
        ->map(
            static function ($value) {
                return floor($value * 1000) + 1;
            }
        )
        ->distinct()
        ->limit(300)
        ->normalize()
        ->all();

    // The famous Fibonacci example:
    Collection::with(
            static function($start = 0, $inc = 1) {
                yield $start;

                while(true)
                {
                    $inc = $start + $inc;
                    $start = $inc - $start;
                    yield $start;
                }
            }
        )
        ->limit(10)
        ->all(); // [0, 1, 1, 2, 3, 5, 8, 13, 21, 34]

    // Fibonacci using the static method ::iterate()
    Collection::iterate(
        static function($previous, $next) {
            return [$next, $previous + $next];
        },
        1,1
        )
        // Get the first item of each result.
        ->pluck(0)
        // Limit the amount of results to 10.
        ->limit(10)
        // Convert to regular array.
        ->all(); // [1, 1, 2, 3, 5, 8, 13, 21, 34, 55]

    // Find the Golden Ratio with Fibonacci
    $fibonacci = Collection::iterate(
        static function($previous, $next) {
            return [$next, $previous + $next];
        },
        1,1
        );

    Collection::with($fibonacci)
        ->map(
            static function(array $value, $key) {
                [$previous, $next] = $value;

                return $next / $previous;
            }
        )
        ->limit(100)
        ->last(); // 1.6180339887499

    // Use an existing Generator as input data.
    $readFileLineByLine = static function (string $filepath): Generator {
        $fh = \fopen($filepath, 'rb');

        while (false !== $line = fgets($fh)) {
            yield $line;
        }

        \fclose($fh);
    };

    $hugeFile = __DIR__ . '/vendor/composer/autoload_static.php';

    Collection::with($readFileLineByLine($hugeFile))
        // Add the line number at the end of the line, as comment.
        ->map(
            static function ($value, $key) {
                return str_replace(PHP_EOL, ' // line ' . $key . PHP_EOL, $value);
            }
        )
        // Find public static fields or methods among the results.
        ->filter(
            static function ($value, $key) {
                return false !== strpos(trim($value), 'public static');
            }
        )
        // Skip the first result.
        ->skip(1)
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
    Collection::with($string)
        ->explode(' ')
        ->count(); // 71

    // Or add a separator if needed, same behavior as explode().
    Collection::with($string, ',')
      ->count(); // 9

    // The Collatz conjecture (https://en.wikipedia.org/wiki/Collatz_conjecture)
    $collatz = static function (int $value): int
    {
        return 0 === $value % 2 ?
            $value / 2:
            $value * 3 + 1;
    };

    Collection::iterate($collatz, 10)
        ->until(static function ($number): bool {
            return 1 === $number;
        })
        ->all(); // [5, 16, 8, 4, 2, 1]

    // Regular values normalization.
    Collection::with([0, 2, 4, 6, 8, 10])
        ->scale(0, 10)
        ->all(); // [0, 0.2, 0.4, 0.6, 0.8, 1]

    // Logarithmic values normalization.
    Collection::with([0, 2, 4, 6, 8, 10])
        ->scale(0, 10, 5, 15, 3)
        ->all(); // [5, 8.01, 11.02, 12.78, 14.03, 15]

    // Fun with function convergence.
    // Iterator over the function: f(x) = r * x * (1-x)
    // Change that parameter $r to see different behavior.
    // More on this: https://en.wikipedia.org/wiki/Logistic_map
    $function = static function ($x = .3, $r = 2) {
        return $r * $x * (1 - $x);
    };

    Collection::iterate($function)
        ->map(static function ($value) {return round($value,2);})
        ->limit(10)
        ->all(); // [0.42, 0.48, 0.49, 0.49, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5]
