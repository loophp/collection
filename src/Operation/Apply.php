<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Apply.
 */
final class Apply extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection): \Closure
    {
        $callbacks = $this->parameters;

        return static function () use ($callbacks, $collection): iterable {
            foreach ($callbacks as $callback) {
                foreach ($collection as $key => $value) {
                    if (false === $callback($value, $key)) {
                        break;
                    }
                }
            }

            yield from $collection;
        };
    }
}
