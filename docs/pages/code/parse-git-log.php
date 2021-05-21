<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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

$buildIfThenElseCallbacks = static function (string $lineStart): array {
    return [
        static function ($line) use ($lineStart): bool {
            return is_string($line) && 0 === mb_strpos($line, $lineStart);
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
        Splitable::BEFORE,
        static function ($value): bool {
            return is_array($value) ?
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
                ->groupBy(
                    static function ($value): ?string {
                        return is_array($value) ? 'headers' : null;
                    }
                )
                ->groupBy(
                    static function ($value): ?string {
                        return is_string($value) ? 'log' : null;
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
                                static function ($carry, $key, string $value): string {
                                    [$key, $line] = explode(':', $value, 2);

                                    return $key;
                                },
                                static function ($carry, $key, string $value): string {
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
                ->groupBy(
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
    ->limit(100);

print_r($c->all());
