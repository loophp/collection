<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Transformation;

/**
 * Class Contains.
 */
final class Contains implements Transformation
{
    /**
     * @var mixed
     */
    private $key;

    /**
     * Contains constructor.
     *
     * @param mixed $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        $key = $this->key;

        if ((false === \is_string($key)) && (true === \is_callable($key))) {
            $placeholder = new \stdClass();

            return (new First($key, $placeholder))->on($collection) !== $placeholder;
        }

        foreach ($collection as $value) {
            if ($value === $key) {
                return true;
            }
        }

        return false;
    }
}
