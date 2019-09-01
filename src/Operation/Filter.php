<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class Filter.
 */
final class Filter implements Operation
{
    /**
     * @var callable[]
     */
    private $callbacks;

    /**
     * Filter constructor.
     *
     * @param callable ...$callbacks
     */
    public function __construct(callable ...$callbacks)
    {
        $this->callbacks = $callbacks;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        $callbacks = $this->callbacks;

        if ([] === $callbacks) {
            $callbacks[] = static function ($value) {
                return $value;
            };
        }

        return static function () use ($callbacks, $collection): \Generator {
            foreach ($callbacks as $callback) {
                foreach ($collection as $key => $value) {
                    if (true === (bool) $callback($value, $key)) {
                        yield $key => $value;
                    }
                }
            }
        };
    }
}
