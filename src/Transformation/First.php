<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

final class First implements Transformation
{
    /**
     * @var callable
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
        $this->callback = $callback ?? static function (): bool {
            return true;
        };
        $this->default = $default;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(iterable $collection)
    {
        $callback = $this->callback;
        $default = $this->default;

        foreach ($collection as $key => $value) {
            if (true === $callback($value, $key)) {
                return $value;
            }
        }

        return $default;
    }
}
