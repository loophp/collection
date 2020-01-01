<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

/**
 * Class First.
 */
final class First implements Transformation
{
    /**
     * @var callable|null
     */
    private $callback;

    /**
     * @var mixed|null
     */
    private $default;

    /**
     * First constructor.
     *
     * @param callable|null $callback
     * @param mixed|null $default
     */
    public function __construct(?callable $callback = null, $default = null)
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
            $callback = static function ($value, $key): bool {
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
