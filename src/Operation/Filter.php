<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Filter.
 */
final class Filter extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function on(\Traversable $collection): \Closure
    {
        [$callbacks] = $this->parameters;

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
