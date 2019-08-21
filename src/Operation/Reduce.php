<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\BaseCollection as CollectionInterface;

/**
 * Class Reduce.
 */
final class Reduce extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(CollectionInterface $collection)
    {
        [$callback, $initial] = $this->parameters;

        $result = $initial;

        foreach ($collection as $value) {
            $result = $callback($result, $value);
        }

        return $result;
    }
}
