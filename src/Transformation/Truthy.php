<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

final class Truthy implements Transformation
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(iterable $collection): bool
    {
        foreach ($collection as $key => $value) {
            if (false === (bool) $value) {
                return false;
            }
        }

        return true;
    }
}
