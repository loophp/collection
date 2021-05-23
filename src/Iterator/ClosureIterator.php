<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Iterator;

use Generator;

/**
 * @internal
 *
 * @template TKey
 * @template T
 *
 * @extends ProxyIterator<TKey, T>
 */
final class ClosureIterator extends ProxyIterator
{
    /**
     * @var array<int, mixed>
<<<<<<< HEAD
=======
     * @var list<mixed>
>>>>>>> 4fe57bd9... Replace @psalm-var with @var.
     */
    private array $arguments;

    /**
<<<<<<< HEAD
     * @var callable(mixed ...$parameters): iterable<TKey, T>
=======
     * @var callable
     * @var callable(mixed ...):Generator<TKey, T>
>>>>>>> 4fe57bd9... Replace @psalm-var with @var.
     */
    private $callable;

    /**
<<<<<<< HEAD
     * @param callable(mixed ...$parameters): iterable<TKey, T> $callable
     * @param mixed ...$arguments
=======
     * @param mixed ...$arguments
     * @param callable(mixed ...):Generator<TKey, T> $callable
>>>>>>> 4fe57bd9... Replace @psalm-var with @var.
     */
    public function __construct(callable $callable, ...$arguments)
    {
        $this->callable = $callable;
        $this->arguments = $arguments;
        $this->iterator = $this->getGenerator();
    }

    public function rewind(): void
    {
        $this->iterator = $this->getGenerator();
    }

    /**
     * @return Generator<TKey, T>
     */
    private function getGenerator(): Generator
    {
        return yield from ($this->callable)(...$this->arguments);
    }
}
