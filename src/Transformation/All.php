<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Transformer;

/**
 * Class All.
 */
final class All implements Transformer
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        $result = [];

        foreach ($collection as $key => $value) {
            if (true === \is_iterable($value)) {
                $result[$key] = $this->on($value);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
