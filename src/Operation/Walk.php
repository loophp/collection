<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Walk.
 */
final class Walk extends Operation
{
    /**
     * Walk constructor.
     *
     * @param callable ...$callbacks
     */
    public function __construct(callable ...$callbacks)
    {
        parent::__construct(...[$callbacks]);
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        [$callbacks] = $this->parameters;

        return static function () use ($callbacks, $collection): \Generator {
            $callback = static function ($carry, $callback) {
                return $callback($carry);
            };

            foreach ($collection as $key => $value) {
                yield $key => \array_reduce($callbacks, $callback, $value);
            }
        };
    }
}
