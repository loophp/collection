<?php

declare(strict_types=1);

namespace loophp\collection\Transformation;

use loophp\collection\Contract\Transformation;

final class FoldLeft implements Transformation
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @var mixed
     */
    private $initial;

    /**
     * FoldLeft constructor.
     *
     * @param mixed|null $initial
     * @param callable $callback
     */
    public function __construct(callable $callback, $initial = null)
    {
        $this->callback = $callback;
        $this->initial = $initial;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(iterable $collection)
    {
        $callback = $this->callback;
        $initial = $this->initial;

        foreach ($collection as $key => $value) {
            $initial = $callback($initial, $value, $key);
        }

        return $initial;
    }
}
