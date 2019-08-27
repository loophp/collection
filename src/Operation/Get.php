<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

/**
 * Class Get.
 */
final class Get extends Operation
{
    /**
     * Get constructor.
     *
     * @param int|string $key
     * @param mixed $default
     */
    public function __construct($key, $default)
    {
        parent::__construct(...[$key, $default]);
    }

    /**
     * {@inheritdoc}
     */
    public function on(\Traversable $collection)
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
