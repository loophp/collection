<?php

declare(strict_types=1);

namespace drupol\collection\Transformation;

use drupol\collection\Contract\Transformer;

/**
 * Class First.
 */
final class First implements Transformer
{
    /**
     * @var null|callable
     */
    private $callback;

    /**
     * @var null|mixed
     */
    private $default;

    /**
     * First constructor.
     *
     * @param null|callable $callback
     * @param null|mixed $default
     */
    public function __construct(callable $callback = null, $default = null)
    {
        $this->callback = $callback;
        $this->default = $default;
    }

    /**
     * {@inheritdoc}
     */
    public function on(iterable $collection)
    {
        $callback = $this->callback;
        $default = $this->default;

        if (null === $callback) {
            $callback = static function ($value, $key) {
                return true;
            };
        }

        foreach ($collection as $key => $value) {
            if (true === $callback($value, $key)) {
                return $value;
            }
        }

        return $default;
    }
}
