<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class All.
 */
final class All extends Operation
{
    /**
     * All constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

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
