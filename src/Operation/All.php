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

        foreach ($collection as $key => $item) {
            if ($item instanceof \Traversable) {
                $subresult = [];

                foreach ($item as $k => $v) {
                    $subresult[$k] = $v;
                }

                $result[$key] = $subresult;
            } else {
                $result[$key] = $item;
            }
        }

        return $result;
    }
}
