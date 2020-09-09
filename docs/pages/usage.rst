Usage
=====

Find here some working examples.

Simple
-------

.. code-block:: php

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use loophp\collection\Collection;

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

    // Use \StdClass as input
    $data = (object) array_combine(range('A', 'E'), range('A', 'E'));

    // Keys are preserved during the map() operation.
    Collection::with(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'])
        ->map(
            static function (string $value, string $key): string {
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
    // However, in loophp/collection it doesn't behave as such.
    // As this library is based on PHP Generators, it's able to return multiple times the same key when iterating.
    // You end up with the following result when issuing twice the ::flip() operation.
    Collection::with(['a', 'b', 'c', 'd', 'a'])
        ->flip()
        ->flip()
        ->all(); // ['a', 'b', 'c', 'd', 'a']

    // Get the Cartesian product.
    Collection::with(['a', 'b'])
        ->product([1, 2])
        ->all(); // [['a', 1], ['a', 2], ['b', 1], ['b', 2]]

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

                return true;
            }
        );

    // Generate 300 distinct random numbers between 0 and 1000
    $random = static function() {
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
    $fibonacci = static function($a = 0, $b = 1): array {
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
            static function(array $value, $key) {
                return $value[1] / $value[0];
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

    Collection::unfold($function)
        ->map(static function ($value) {return round($value,2);})
        ->limit(10)
        ->all(); // [0.42, 0.48, 0.49, 0.49, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5]

    // Infinitely loop over a collection
    Collection::with(['A', 'B', 'C'])
        ->loop();

    // Traverse the collection using windows of a given size.
    Collection::with(range('a', 'z'))
        ->window(3)
        ->all(); // [['a'], ['a', 'b'], ['a', 'b', 'c'], ['b', 'c', 'd'], ['c', 'd', 'e'], ...]

    Collection::with(range('a', 'd'))
        ->wrap()
        ->all(); // [['a'], ['b'], ['c'], ['d']]

    Collection::with([['a'], ['b'], ['c'], ['d']])
        ->unwrap()
        ->all(); // ['a', 'b', 'c', 'd']

Advanced
--------

Manipulate keys and values
~~~~~~~~~~~~~~~~~~~~~~~~~~

This example show the power of a lazy library and highlight also how to use
it in a wrong way.

Unlike regular PHP arrays where there can only be one key of type int or
string, a lazy library can have multiple times the same keys and they can
be of any type !

.. code-block:: bash

    // This following example is perfectly valid, despite that having array for keys
    // in a regular PHP arrays is impossible.
    $input = static function () {
        yield ['a'] => 'a';
        yield ['b'] => 'b';
        yield ['c'] => 'c';
    };
    Collection::fromIterable($input());

A lazy collection library can also have multiple times the same key.

Here we are going to make a frequency analysis on the text and see the
result. We can see that some data are missing, why ?

.. code-block:: bash

    $string = 'aaaaabbbbcccddddeeeee';

    $collection = Collection::with($string)
        // Run the frequency analysis tool.
        ->frequency()
        // Convert to regular array.
        ->all(); // [5 => 'e', 4 => 'd', 3 => 'c']

The reason that the frequency analysis for letters 'a' and 'b' are missing
is because when you call the method ->all(), the collection converts the
lazy collection into a regular PHP array, and PHP doesn't allow having
multiple time the same key, so it overrides the previous data and there are
missing information in the resulting array.

In order to circumvent this, you can either wrap the final result or
normalize it.
A better way would be to not convert this into an array and use the lazy
collection as an iterator.

Wrapping the result will wrap each result into a PHP array.
Normalizing the result will replace keys with a numerical index, but then
you might lose some information then.

It's up to you to decide which one you want to use.

.. code-block:: bash

    $collection = Collection::with($string)
        // Run the frequency analysis tool.
        ->frequency()
        // Wrap each result into an array.
        ->wrap()
        // Convert to regular array.
        ->all();
    /**
     * [
     *   [5 => 'a'],
     *   [4 => 'b'],
     *   [3 => 'c'],
     *   [4 => 'd'],
     *   [5 => 'e'],
     * ]
     */

Manipulate strings
~~~~~~~~~~~~~~~~~~

.. code-block:: bash

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use loophp\collection\Collection;

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

Random number generation
~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use loophp\collection\Collection;

    // Generate 300 distinct random numbers between 0 and 1000
    $random = static function() {
        return mt_rand() / mt_getrandmax();
    };

    $random_numbers = Collection::unfold($random)
        ->map(
            static function ($value) {
                return floor($value * 1000) + 1;
            }
        )
        ->distinct()
        ->limit(300)
        ->normalize()
        ->all();

    print_r($random_numbers);

Approximate the number e
~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use loophp\collection\Collection;

    $multiplication = static function (float $value1, float $value2): float {
        return $value1 * $value2;
    };

    $addition = static function (float $value1, float $value2): float {
        return $value1 + $value2;
    };

    $fact = static function (int $number) use ($multiplication): float {
        return Collection::range(1, $number + 1)
            ->reduce(
                $multiplication,
                1
            );
    };

    $e = static function (int $value) use ($fact): float {
        return $value / $fact($value);
    };

    $listInt = static function(int $init, callable $succ): Generator
    {
        yield $init;

        while (true) {
            yield $init = $succ($init);
        }
    };

    $naturals = $listInt(1, static function (int $n): int {return $n + 1;});

    $number_e_approximation = Collection::fromIterable($naturals)
        ->map($e)
        ->until(static function (float $value): bool {return $value < 10 ** -12;})
        ->reduce($addition, 0);

    var_dump($number_e_approximation); // 2.718281828459

Approximate the number Pi
~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use loophp\collection\Collection;

    $monteCarloMethod = static function ($in = 0, $total = 1) {
        $randomNumber1 = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
        $randomNumber2 = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();

        if (1 >= (($randomNumber1 ** 2) + ($randomNumber2 ** 2))) {
            ++$in;
        }

        return ['in' => $in, 'total' => ++$total];
    };

    $pi_approximation = Collection::unfold($monteCarloMethod)
        ->map(
            static function ($value) {
                return 4 * $value['in'] / $value['total'];
            }
        )
        ->window(1)
        ->drop(1)
        ->until(
            static function (array $value): bool {
                return 0.00001 > abs($value[0] - $value[1]);
            }
        )
        ->last();

    print_r($pi_approximation->all());

Fibonacci sequence
~~~~~~~~~~~~~~~~~~

.. code-block:: php

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use loophp\collection\Collection;

    $fibonacci = static function(int $a = 0, int $b = 1): array {
        return [$b, $b + $a];
    };

    $c = Collection::unfold($fibonacci)
        ->pluck(0)    // Get the first item of each result.
        ->limit(10);  // Limit the amount of results to 10.

    print_r($c->all()); // [1, 1, 2, 3, 5, 8, 13, 21, 34, 55]

Gamma function
~~~~~~~~~~~~~~

.. code-block:: php

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use loophp\collection\Collection;

    $addition = static function (float $value1, float $value2): float {
        return $value1 + $value2;
    };

    $listInt = static function(int $init, callable $succ): Generator
    {
        yield $init;

        while (true) {
            yield $init = $succ($init);
        }
    };

    $ℕ = $listInt(1, static function (int $n): int {return $n + 1;});

    $γ = static function (float $n): \Closure
    {
        return static function (int $x) use ($n): float
        {
            return ($x ** ($n - 1)) * (M_E ** (-$x));
        };
    };

    $ε = static function (float $value): bool {return $value < 10 ** -12;};

    // Find the factorial of this number. This is not bounded to integers!
    // $number = 3; // 2 * 2 => 4
    // $number = 6; // 5 * 4 * 3 * 2 => 120
    $number = 5.75; // 78.78

    $gamma_factorial_approximation = Collection::fromIterable($ℕ)
        ->map($γ($number))
        ->until($ε)
        ->reduce($addition, 0);

    print_r($gamma_factorial_approximation); // 78.78

Prime numbers
~~~~~~~~~~~~~

.. code-block:: php

    <?php

    /**
     * Run this code with: "php -n <file.php>" to make sure no configuration will be used
     * so xdebug will not be used either.
     */

    declare(strict_types=1);

    include __DIR__ . '/vendor/autoload.php';

    use loophp\collection\Collection;

    function primesGenerator(Iterator $iterator): Generator
    {
        yield $primeNumber = $iterator->current();

        $iterator = new \CallbackFilterIterator(
            $iterator,
            fn(int $a): bool => $a % $primeNumber !== 0
        );

        $iterator->next();

        return $iterator->valid() ?
            yield from primesGenerator($iterator):
            null;
    }

    function integerGenerator(int $init = 1, callable $succ): Generator
    {
        yield $init;

        return yield from integerGenerator($succ($init), $succ);
    }

    $primes = primesGenerator(integerGenerator(2, fn(int $n): int => $n + 1));

    $limit = 1000000;

    // Create a lazy collection of Prime numbers from 2 to infinity.
    $lazyPrimeNumbersCollection = Collection::fromIterable(
        primesGenerator(
            integerGenerator(2, static fn ($n) => $n + 1)
        )
    );

    // Print out the first 1 million of prime numbers.
    foreach ($lazyPrimeNumbersCollection->limit($limit) as $prime) {
        var_dump($prime);
    }

    // Create a lazy collection of Prime numbers from 2 to infinity.
    $lazyPrimeNumbersCollection = Collection::fromIterable(
        primesGenerator(
            integerGenerator(2, static fn ($n) => $n + 1)
        )
    );

    // Find out the Twin Prime numbers by filtering out unwanted values.
    $lazyTwinPrimeNumbersCollection = Collection::fromIterable($lazyPrimeNumbersCollection)
        ->zip($lazyPrimeNumbersCollection->tail())
        ->filter(static fn (array $chunk): bool => 2 === $chunk[1] - $chunk[0]);

    foreach ($lazyTwinPrimeNumbersCollection->limit($limit) as $prime) {
        var_dump($prime);
    }

Text analysis
~~~~~~~~~~~~~

.. code-block:: php

    <?php

    declare(strict_types=1);

    include __DIR__ . '/vendor/autoload.php';

    use loophp\collection\Collection;

    $collection = Collection::with(file_get_contents('http://loripsum.net/api'))
        // Filter out some characters.
        ->filter(
            static function ($item, $key): bool {
                return (bool) preg_match('/^[a-zA-Z]+$/', $item);
            }
        )
        // Lowercase each character.
        ->map(static function (string $letter): string {
            return mb_strtolower($letter);
        })
        // Run the frequency tool.
        ->frequency()
        // Flip keys and values.
        ->flip()
        // Sort values.
        ->sort()
        // Convert to array.
        ->all();

    print_r($collection);

Random number distribution
~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: php

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use loophp\collection\Collection;
    use loophp\collection\Contract\Operation\Sortable;

    $min = 0;
    $max = 100;
    $groups = 10;

    $randomGenerator = static function () use ($min, $max): int {
        return random_int($min, $max);
    };

    $distribution = Collection::unfold($randomGenerator)
        ->limit($max * $max)
        ->associate(
            static function (int $key, int $value) use ($max, $groups): string {
                for ($i = 0; ($max / $groups) > $i; ++$i) {
                    if ($i * $groups <= $value && ($i + 1) * $groups >= $value) {
                        return sprintf('%s <= x <= %s', $i * $groups, ($i + 1) * $groups);
                    }
                }
            }
        )
        ->group()
        ->map(
            static function (array $value): int {
                return \count($value);
            }
        )
        ->sort(
            Sortable::BY_KEYS,
            static function (string $left, string $right): int {
                [$left_min_limit] = explode(' ', $left);
                [$right_min_limit] = explode(' ', $right);

                return $left_min_limit <=> $right_min_limit;
            }
        );

    print_r($distribution->all());

    /*
    Array
    (
        [0 <= x <= 100] => 101086
        [100 <= x <= 200] => 100144
        [200 <= x <= 300] => 99408
        [300 <= x <= 400] => 100079
        [400 <= x <= 500] => 99514
        [500 <= x <= 600] => 100227
        [600 <= x <= 700] => 99983
        [700 <= x <= 800] => 99942
        [800 <= x <= 900] => 99429
        [900 <= x <= 1000] => 100188
    )
    */

Parse git log
~~~~~~~~~~~~~

.. code-block:: php

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use loophp\collection\Collection;
    use loophp\collection\Contract\Collection as CollectionInterface;

    $commandStream = static function (string $command): Generator {
        $fh = popen($command, 'r');

        while (false !== $line = fgets($fh)) {
            yield $line;
        }

        fclose($fh);
    };

    $buildIfThenElseCallbacks = static function (string $lineStart): array {
        return [
            static function ($line) use ($lineStart): bool {
                return \is_string($line) && 0 === mb_strpos($line, $lineStart);
            },
            static function ($line) use ($lineStart): array {
                [, $line] = explode($lineStart, $line);

                return [
                    sprintf(
                        '%s:%s',
                        mb_strtolower(str_replace(':', '', $lineStart)),
                        trim($line)
                    ),
                ];
            },
        ];
    };

    $c = Collection::fromIterable($commandStream('git log'))
        ->map(
            static function (string $value): string {
                return trim($value);
            }
        )
        ->compact('', ' ', "\n")
        ->ifThenElse(...$buildIfThenElseCallbacks('commit'))
        ->ifThenElse(...$buildIfThenElseCallbacks('Date:'))
        ->ifThenElse(...$buildIfThenElseCallbacks('Author:'))
        ->ifThenElse(...$buildIfThenElseCallbacks('Merge:'))
        ->ifThenElse(...$buildIfThenElseCallbacks('Signed-off-by:'))
        ->split(
            static function ($value): bool {
                return \is_array($value) ?
                    (1 === preg_match('/^commit:\b[0-9a-f]{5,40}\b/', $value[0])) :
                    false;
            }
        )
        ->map(
            static function (array $value): CollectionInterface {
                return Collection::fromIterable($value);
            }
        )
        ->map(
            static function (CollectionInterface $collection): CollectionInterface {
                return $collection
                    ->group(
                        static function ($value): ?string {
                            return \is_array($value) ? 'headers' : null;
                        }
                    )
                    ->group(
                        static function ($value): ?string {
                            return \is_string($value) ? 'log' : null;
                        }
                    )
                    ->ifThenElse(
                        static function ($value, $key): bool {
                            return 'headers' === $key;
                        },
                        static function ($value, $key): array {
                            return Collection::fromIterable($value)
                                ->unwrap()
                                ->associate(
                                    static function ($key, string $value): string {
                                        [$key, $line] = explode(':', $value, 2);

                                        return $key;
                                    },
                                    static function ($key, string $value): string {
                                        [$key, $line] = explode(':', $value, 2);

                                        return trim($line);
                                    }
                                )
                                ->all();
                        }
                    );
            }
        )
        ->map(
            static function (CollectionInterface $collection): CollectionInterface {
                return $collection
                    ->flatten()
                    ->group(
                        static function ($value, $key): ?string {
                            if (is_numeric($key)) {
                                return 'log';
                            }

                            return null;
                        }
                    );
            }
        )
        ->map(
            static function (CollectionInterface $collection): array {
                return $collection->all();
            }
        )
        ->limit(52);

    print_r($c->all());

Collatz conjecture
~~~~~~~~~~~~~~~~~~

.. code-block:: php

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use loophp\collection\Collection;

    // The Collatz conjecture (https://en.wikipedia.org/wiki/Collatz_conjecture)
    $collatz = static function (int $value): int
    {
        return 0 === $value % 2 ?
            $value / 2:
            $value * 3 + 1;
    };

    $c = Collection::unfold($collatz, 25)
        ->until(
            static function ($number): bool {
                return 1 === $number;
            }
        );

    print_r($c->all()); // [25, 76, 38, 19, 58, 29, 88, 44, 22, 11, 34, 17, 52, 26, 13, 40, 20, 10, 5, 16, 8, 4, 2, 1]
