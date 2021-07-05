<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;

/**
 * @param CollectionInterface<int, bool> $collection
 */
function has_checkList(CollectionInterface $collection): void
{
}
/**
 * @param CollectionInterface<string, bool> $collection
 */
function has_checkMap(CollectionInterface $collection): void
{
}
function has_checkBool(bool $value): void
{
}

$number2 = static fn (): int => 2;
$number3 = static fn (): int => 2;
$square = static fn (int $value): int => $value ** 2;
$withKey = static fn (int $value, int $key): int => 1 < $key ? 3 : 1;

$letterF = static fn (): string => 'f';
$letterZ = static fn (): string => 'z';
$letterB = static fn (): string => 'b';
$capital = static fn (string $value): string => strtoupper($value);
$withStringKey = static fn (string $value, string $key): string => 'foo' === $key ? 'f' : 'b';

has_checkList(Collection::fromIterable([1, 2, 3])->has($number2));
has_checkList(Collection::fromIterable(range(1, 3))->has($number2, $number2));
has_checkList(Collection::fromIterable([1, 2, 3])->has($withKey));

has_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->has($letterF));
has_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->has($letterF, $letterB));
has_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->has($withStringKey));

// These are valid and should work, however Psalm restricts the values that the callable
// is allowed to return to the values contained in the collection

/** @psalm-suppress ArgumentTypeCoercion */
has_checkList(Collection::fromIterable([1, 2, 3])->has($square));
/** @psalm-suppress InvalidArgument */
has_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->has($letterZ));
/** @psalm-suppress ArgumentTypeCoercion */
has_checkMap(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->has($capital));

// This retrieval method doesn't cause static analysis complaints
// but is not always reliable because of that.
has_checkBool(Collection::fromIterable([1, 2, 3])->has($number2)->all()[0]);
has_checkBool(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->has($letterF)->all()['foo']);
/** @psalm-suppress InvalidArrayOffset -> in this case Psalm can tell that the key won't exist */
has_checkBool(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->has($letterF)->all()['randomKey']);

// VALID failures below -> `current` can return `NULL` if the collection is empty

/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
has_checkBool(Collection::fromIterable([1, 2, 3])->has($number2)->current());
/** @psalm-suppress PossiblyNullArgument @phpstan-ignore-next-line */
has_checkBool(Collection::fromIterable(['foo' => 'f', 'bar' => 'b'])->has($letterF)->current());

// explicit check is needed for PHPStan because the value is of type `bool|null`
if (true === Collection::fromIterable([1, 2, 3])->has($number2)->current()) {
}
