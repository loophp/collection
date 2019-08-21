<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Get.
 */
final class Get extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection)
    {
        [$key, $default] = $this->parameters;

        foreach ($collection as $outerKey => $outerValue) {
            if ($outerKey === $key) {
                return $outerValue;
            }
        }

        return $default;
    }
}
