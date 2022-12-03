<?php

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;
use loophp\collection\Contract\Operation\Splitable;

$commandStream = static function (string $command): Generator {
    /** @var resource $fh */
    $fh = popen($command, 'r');

    while (false !== $line = fgets($fh)) {
        yield $line;
    }

    fclose($fh);
};

$buildIfThenElseCallbacks = static fn (string $lineStart): array => [
    static fn ($line): bool => is_string($line) && 0 === mb_strpos($line, $lineStart),
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

$c = Collection::fromIterable($commandStream('git log'))
    ->map(
        static fn (string $value): string => trim($value)
    )
    ->compact('', ' ', "\n")
    ->ifThenElse(...$buildIfThenElseCallbacks('commit'))
    ->ifThenElse(...$buildIfThenElseCallbacks('Date:'))
    ->ifThenElse(...$buildIfThenElseCallbacks('Author:'))
    ->ifThenElse(...$buildIfThenElseCallbacks('Merge:'))
    ->ifThenElse(...$buildIfThenElseCallbacks('Signed-off-by:'))
    ->split(
        Splitable::BEFORE,
        static fn ($value): bool => is_array($value) ?
            (1 === preg_match('/^commit:\b[0-9a-f]{5,40}\b/', $value[0])) :
            false
    )
    ->map(
        static fn (array $value): CollectionInterface => Collection::fromIterable($value)
    )
    ->map(
        static fn (CollectionInterface $collection): CollectionInterface => $collection
            ->groupBy(
                static fn ($value): ?string => is_array($value) ? 'headers' : null
            )
            ->groupBy(
                static fn ($value): ?string => is_string($value) ? 'log' : null
            )
            ->ifThenElse(
                static fn ($value, $key): bool => 'headers' === $key,
                static fn ($value, $key): array => Collection::fromIterable($value)
                    ->unwrap()
                    ->associate(
                        static function ($carry, $key, string $value): string {
                            [$key, $line] = explode(':', $value, 2);

                            return $key;
                        },
                        static function ($carry, $key, string $value): string {
                            [$key, $line] = explode(':', $value, 2);

                            return trim($line);
                        }
                    )
                    ->all()
            )
    )
    ->map(
        static fn (CollectionInterface $collection): CollectionInterface => $collection
            ->flatten()
            ->groupBy(
                static function ($value, $key): ?string {
                    if (is_numeric($key)) {
                        return 'log';
                    }

                    return null;
                }
            )
    )
    ->map(
        static fn (CollectionInterface $collection): array => $collection->all()
    )
    ->limit(100);

print_r($c->all());
