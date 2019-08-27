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
    public function on(iterable $collection): iterable
    {
        [$callbacks] = $this->parameters;

        foreach ($callbacks as $callback) {
            foreach ($collection as $key => $item) {
                if (false === $callback($item, $key)) {
                    break;
                }
            }
        }

        return $collection;
    }
}
