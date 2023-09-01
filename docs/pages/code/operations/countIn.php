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
    ->all();
