<?php

declare(strict_types=1);

namespace drupol\collection\Operation;

use drupol\collection\Contract\Operation;

/**
 * Class First.
 */
final class First implements Operation
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
            $callback = static function ($v, $k) {
                return true;
            };
        }

        foreach ($collection as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }

        return $default;
    }
}
