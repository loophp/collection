<?php

declare(strict_types=1);

include __DIR__ . '/../../vendor/autoload.php';

use loophp\collection\Collection;

enum fromIterableAssociateAll: int
{
    case FIFTH = 5;
    case FIRST = 1;
    case FOURTH = 4;
    case SECOND = 2;
    case THIRD = 3;
}

/**
 * @psalm-param array<string, int> $array
 *
 * @phpstan-param array<string, int> $array
 */
function checklist(array $array): void {}

checklist(Collection::fromIterable(fromIterableAssociateAll::cases())->associate(
    static fn (int $_, fromIterableAssociateAll $item) => $item->value,
    static fn (fromIterableAssociateAll $item, int $_) => $item->name,
)->flip()->all(false));
