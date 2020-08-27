<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\collection\Contract\Operation;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class IfThenElse extends AbstractOperation implements Operation
{
    /**
     * @psalm-param callable(T, TKey): bool $condition
     * @psalm-param callable(T, TKey): (T|TKey) $then
     * @psalm-param callable(T, TKey): (T|TKey) $else
     */
    public function __construct(callable $condition, callable $then, callable $else)
    {
        $this->storage = [
            'condition' => $condition,
            'then' => $then,
            'else' => $else,
        ];
    }

    // phpcs:disable
    /**
     * @psalm-return Closure(Iterator<TKey, T>, callable(T, TKey): bool, callable(T, TKey): (T|TKey), callable(T, TKey): (T|TKey)): Generator<TKey, T>
     */
    // phpcs:enable
    public function __invoke(): Closure
    {
        return static function (Iterator $iterator, callable $condition, callable $then, callable $else): Generator {
            foreach ($iterator as $key => $value) {
                yield $key => $condition($value, $key) ?
                    $then($value, $key) :
                    $else($value, $key);
            }
        };
    }
}
