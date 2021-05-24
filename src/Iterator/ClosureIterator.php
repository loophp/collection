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
     * @var list<mixed>
     */
    private array $arguments;

    /**
     * @var callable(mixed ...): Generator<TKey, T>
     */
    private $callable;

    /**
     * @param mixed ...$arguments
     * @param callable(mixed ...):Generator<TKey, T> $callable
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
