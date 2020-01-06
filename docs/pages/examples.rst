Examples
========

Approximate the number e
------------------------

.. code-block:: bash

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use loophp\collection\Collection;

    $multiplication = static function ($value1, $value2) {
        return $value1 * $value2;
    };

    $addition = static function ($value1, $value2) {
        return $value1 + $value2;
    };

    $fact = static function (int $number) use ($multiplication) {
        return Collection::range(1, $number + 1)
            ->reduce(
                $multiplication,
                1
            );
    };

    $e = static function (int $value) use ($fact): float {
        return $value / $fact($value);
    };

    $number_e_approximation = Collection::times(INF, $e)
        ->until(static function (float $value): bool {return $value < 10 ** -12;})
        ->reduce($addition);

    var_dump($number_e_approximation); // 2.718281828459

Approximate the number Pi
-------------------------

.. code-block:: php

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use loophp\collection\Collection;

    $iterations = 100000;

    $monteCarloMethod = static function ($in = 0) {
        $randomNumber1 = mt_rand() / mt_getrandmax();
        $randomNumber2 = mt_rand() / mt_getrandmax();

        if (1 >= (($randomNumber1 ** 2) + ($randomNumber2 ** 2))) {
            ++$in;
        }

        return $in;
    };

    $pi_approximation = Collection::iterate($monteCarloMethod)
        ->limit($iterations)
        ->tail()
        ->map(
            static function ($value) use ($iterations) {
                return 4 * $value / $iterations;
            }
        )
        ->first();

    var_dump($pi_approximation); // 3.1416764444444

Find Prime numbers
------------------

.. code-block:: php

    <?php

    declare(strict_types=1);

    include 'vendor/autoload.php';

    use loophp\collection\Collection;
    use function in_array;

    use const INF;

    /**
     * Get the divisor of a given number.
     *
     * @param float $num
     *   The number.
     * @param int $start
     *   The start.
     *
     * @return \Traversable
     *   The divisors of the number.
     */
    function factors(float $num, int $start = 1): Traversable
    {
        if (0 === $num % $start) {
            yield $start => $start;

            yield $num / $start => $num / $start;
        }

        if (ceil(sqrt($num)) >= $start) {
            yield from factors($num, $start + 1);
        }
    }

    /**
     * Check if a number is a multiple of 2.
     *
     * @param $value
     *   The number.
     *
     * @return bool
     *   Whether or not the number is a multiple of 2.
     */
    $notMultipleOf2 = static function ($value): bool {
        return 0 !== $value % 2;
    };

    /**
     * Check if a number is a multiple of 3.
     *
     * @param $value
     *   The number.
     *
     * @return bool
     *   Whether or not the number is a multiple of 3.
     */
    $notMultipleOf3 = static function ($value): bool {
        $sumIntegers = static function ($value): float {
            return array_reduce(
                mb_str_split((string) $value),
                static function ($carry, $value) {
                    return $value + $carry;
                },
                0
            );
        };

        $sum = $sumIntegers($value);

        while (10 < $sum) {
            $sum = $sumIntegers($sum);
        }

        return 0 !== $sum % 3;
    };

    /**
     * Check if a number is a multiple of 5.
     *
     * @param $value
     *   The number.
     *
     * @return bool
     *   Whether or not the number is a multiple of 5.
     */
    $notMultipleOf5 = static function ($value): bool {
        return !in_array(mb_substr((string) $value, -1), ['0', '5'], true);
    };

    /**
     * Check if a number is a multiple of 7.
     *
     * @param $value
     *   The number.
     *
     * @return bool
     *   Whether or not the number is a multiple of 7.
     */
    $notMultipleOf7 = static function ($value): bool {
        $number = $value;

        while (14 <= $number) {
            $lastDigit = mb_substr((string) $number, -1);

            if ('0' === $lastDigit) {
                return true;
            }

            $number = (int) abs((int) mb_substr((string) $number, 0, -1) - 2 * (int) $lastDigit);
        }

        return !(0 === $number || 7 === $number);
    };

    /**
     * Check if a number is a multiple of 11.
     *
     * @param $value
     *   The number.
     *
     * @return bool
     *   Whether or not the number is a multiple of 11.
     */
    $notMultipleOf11 = static function ($value): bool {
        $number = $value;

        while (11 < $number) {
            $lastDigit = mb_substr((string) $number, -1);

            if ('0' === $lastDigit) {
                return true;
            }

            $number = (int) abs((int) mb_substr((string) $number, 0, -1) - (int) $lastDigit);
        }

        return !(0 === $number || 11 === $number);
    };

    /**
     * Check if a number have more than 2 divisors.
     *
     * @param $value
     *   The number.
     *
     * @return bool
     *   Whether or not the number has more than 2 divisors.
     */
    $valueHavingMoreThan2Divisors = static function ($value): bool {
        $i = 0;

        foreach (factors($value) as $factor) {
            if (2 < $i++) {
                return false;
            }
        }

        return true;
    };

    $primes = Collection::range(9, INF, 2) // Count from 10 to infinity
        ->filter($notMultipleOf2) // Filter out multiples of 2
        ->filter($notMultipleOf3) // Filter out multiples of 3
        ->filter($notMultipleOf5) // Filter out multiples of 5
        ->filter($notMultipleOf7) // Filter out multiples of 7
        ->filter($notMultipleOf11) // Filter out multiples of 11
        ->filter($valueHavingMoreThan2Divisors) // Filter out remaining values having more than 2 divisors.
        ->prepend(2, 3, 5, 7) // Add back digits that were removed
        ->normalize() // Re-index the keys
        ->limit(100); // Take the 100 first prime numbers.

    print_r($primes->all());
