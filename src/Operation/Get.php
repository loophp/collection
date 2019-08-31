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
    public function on(iterable $collection)
    {
        [$keyToGet, $default] = $this->parameters;

        foreach ($collection as $key => $value) {
            if ($key === $keyToGet) {
                return $value;
            }
        }

        return $default;
    }
}
