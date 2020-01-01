<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

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
