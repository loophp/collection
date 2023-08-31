<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Operation\Splitable;

Collection::fromResource(\STDIN)
    ->split(Splitable::REMOVE, static fn (string $char): bool => "\n" === $char)
    ->map(static fn (array $chars): int => (int) implode('', $chars))
    ->filter(static fn (int $value): bool => 0 <= $value)
    ->map(static fn (int $value): string => sprintf("Result: %s\n", [$value, 'Buzz', 'Fizz', 'Fizz Buzz'][($value % 3 === 0 ? 2 : 0) | ($value % 5 === 0 ? 1 : 0)]))
    ->apply(static fn (string $value): int|false => fwrite(\STDOUT, $value))
    ->all();
