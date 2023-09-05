<?php

declare(strict_types=1);

include __DIR__ . '/../../../../vendor/autoload.php';

use loophp\collection\Collection;

$lettersCounter = $wordsCounter = 0;

$collection = Collection::fromString('The quick brown fox jumps over the lazy dog')
    ->countIn($lettersCounter)
    ->words()
    ->countIn($wordsCounter)
    ->map(
        static function (string $word, int $k) use ($wordsCounter): string {
            return sprintf('[%s/%s]: %s', $k + 1, $wordsCounter, $word);
        }
    )
    ->all(); // [ "[1/9]: The", "[2/9]: quick", "[3/9]: brown", "[4/9]: fox", "[5/9]: jumps", "[6/9]: over", "[7/9]: the", "[8/9]: lazy", "[9/9]: dog" ]

    print_r($wordsCounter); // 9
    print_r($lettersCounter); // 43
