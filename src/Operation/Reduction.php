<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;

/**
 * Class Reduction.
 */
final class Reduction implements Operation
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @var mixed
     */
    private $initial;

    /**
     * Reduction constructor.
     *
     * @param callable $callback
     * @param mixed|null $initial
     */
    public function __construct(callable $callback, $initial = null)
    {
        $this->callback = $callback;
        $this->initial = $initial;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        $callback = $this->callback;
        $initial = $this->initial;

        return static function (iterable $collection) use ($callback, $initial): Generator {
            $carry = $initial;

            foreach ($collection as $key => $value) {
                yield $carry = $callback($carry, $value, $key);
            }
        };
    }
}
