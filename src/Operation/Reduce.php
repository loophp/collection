<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Reduce.
 */
final class Reduce extends Operation
{
    /**
     * {@inheritdoc}
     */
    public function run(\IteratorAggregate $collection)
    {
        [$callback, $initial] = $this->parameters;

        $result = $initial;

        foreach ($collection as $value) {
            $result = $callback($result, $value);
        }

        return $result;
    }
}
