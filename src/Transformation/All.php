<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Transformation;

/**
 * Class All.
 */
final class All implements Transformation
{
    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        $result = [];

        foreach ($collection as $key => $value) {
            $result[$key] = is_iterable($value) ?
                $this->on($value) :
                $value;
        }

        return $result;
    }
}
