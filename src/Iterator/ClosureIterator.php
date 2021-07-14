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
    private iterable $arguments;

    /**
     * @var callable(mixed ...$arguments): iterable<TKey, T>
     */
    private $callable;

    /**
     * @param callable(mixed ...$arguments): iterable<TKey, T> $callable
     * @param mixed ...$arguments
     */
    public function __construct(callable $callable, iterable $arguments)
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
        print_r($this->callable);
        var_dump($this->arguments);

        return yield from ($this->callable)(...$this->arguments);
    }
}
