<?php

declare(strict_types=1);

namespace tests\loophp\collection;

final class NamedItem
{
    public function __construct(private string $name) {}

    public function name(): string
    {
        return $this->name;
    }
}
