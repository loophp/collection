<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as BaseCollectionInterface;

/**
 * Class Filter.
 */
final class Filter extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(BaseCollectionInterface $collection): BaseCollectionInterface
    {
        [$callbacks] = $this->parameters;

        if ([] === $callbacks) {
            $callbacks[] = static function ($value) {
                return $value;
            };
        }

        return $collection::with(
            static function () use ($callbacks, $collection): \Generator {
                foreach ($callbacks as $callback) {
                    foreach ($collection as $key => $value) {
                        if (true === (bool) $callback($value, $key)) {
                            yield $key => $value;
                        }
                    }
                }
            }
        );
    }
}
