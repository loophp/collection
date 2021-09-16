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
     * @var callable(mixed ...$parameters): iterable<TKey, T>
     */
    private $callable;

    /**
     * @var iterable<int, mixed>
     */
    private iterable $parameters;

    /**
     * @param callable(mixed ...$parameters): iterable<TKey, T> $callable
     * @param iterable<int, mixed> $parameters
     */
    public function __construct(callable $callable, iterable $parameters)
    {
        $this->callable = $callable;
        $this->parameters = $parameters;
        $this->iterator = $this->getGenerator();
    }

    public function rewind(): void
    {
        $this->iterator = $this->getGenerator();
    }

    /**
     * @return Generator<TKey, T, mixed, void>
     */
    private function getGenerator(): Generator
    {
        yield from ($this->callable)(...$this->parameters);
    }
}
