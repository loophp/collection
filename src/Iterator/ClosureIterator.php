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
     * @var list<mixed>
     */
    private $parameters;

    /**
     * @param callable(mixed ...$parameters): iterable<TKey, T> $callable
     * @param mixed ...$parameters
     */
    public function __construct(callable $callable, ...$parameters)
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
     * @return Generator<TKey, T>
     */
    private function getGenerator(): Generator
    {
        return yield from ($this->callable)(...$this->parameters);
    }
}
