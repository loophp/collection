<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;

$primesGenerator = static function (Iterator $iterator) use (&$primesGenerator): Generator {
    yield $primeNumber = $iterator->current();

    $iterator = new \CallbackFilterIterator(
        $iterator,
        static function (int $a) use ($primeNumber): bool {
            return 0 !== $a % $primeNumber;
        }
    );

    $iterator->next();

    return $iterator->valid() ?
        yield from $primesGenerator($iterator) :
        null;
};

$integerGenerator = static function (int $init, callable $succ) use (&$integerGenerator): Generator {
    yield $init;

    return yield from $integerGenerator($succ($init), $succ);
};

$limit = 1000000;

$primes = $primesGenerator(
    $integerGenerator(
        2,
        static function (int $n): int {
            return $n + 1;
        }
    )
);

// Create a lazy collection of Prime numbers from 2 to infinity.
$lazyPrimeNumbersCollection = Collection::fromIterable(
    $primesGenerator(
        $integerGenerator(
            2,
            static function (int $n): int {
                return $n + 1;
            }
        )
    )
);

// Print out the first 1 million of prime numbers.
foreach ($lazyPrimeNumbersCollection->limit($limit) as $prime) {
    var_dump($prime);
}

// Create a lazy collection of Prime numbers from 2 to infinity.
$lazyPrimeNumbersCollection = Collection::fromIterable(
    $primesGenerator(
        $integerGenerator(
            2,
            static function (int $n): int {
                return $n + 1;
            }
        )
    )
);

// Find out the Twin Prime numbers by filtering out unwanted values.
$lazyTwinPrimeNumbersCollection = Collection::fromIterable($lazyPrimeNumbersCollection)
    ->zip($lazyPrimeNumbersCollection->tail())
    ->filter(
        static function (array $chunk): bool {
            return 2 === $chunk[1] - $chunk[0];
        }
    );

foreach ($lazyTwinPrimeNumbersCollection->limit($limit) as $prime) {
    var_dump($prime);
}
