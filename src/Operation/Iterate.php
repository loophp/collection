<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

/**
 * Class Iterate.
 */
final class Iterate implements Operation
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @var array<mixed>
     */
    private $parameters;

    /**
     * Iterate constructor.
     *
     * @param callable $callback
     * @param array<mixed> $parameters
     */
    public function __construct(callable $callback, array $parameters = [])
    {
        $this->callback = $callback;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): Closure
    {
        $callback = $this->callback;
        $parameters = $this->parameters;

        return static function () use ($callback, $parameters): Generator {
            while (true) {
                yield $parameters = $callback(...(array) $parameters);
            }
        };
    }
}
