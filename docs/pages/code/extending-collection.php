<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

include __DIR__ . '/../../../vendor/autoload.php';

use loophp\collection\Collection;
use loophp\collection\Contract\Collection as CollectionInterface;
use loophp\collection\Operation\AbstractOperation;
use loophp\collection\Operation\Append;

interface FoobarCollectionInterface extends CollectionInterface
{
    public function foobar(): FoobarCollectionInterface;
}

final class Foobar extends AbstractOperation
{
    public function __invoke(): Closure
    {
        return static function (Iterator $iterator): Generator {
            foreach ($iterator as $key => $value) {
                yield 'foo' => 'bar';
            }
        };
    }
}

final class FoobarCollection implements FoobarCollectionInterface
{
    private CollectionInterface $collection;

    public function __construct(callable $callable, ...$parameters)
    {
        $this->collection = new Collection($callable, ...$parameters);
    }

    public function append(...$items): FoobarCollectionInterface
    {
        return new self(Append::of()(...$items), $this->collection);
    }

    public function foobar(): FoobarCollectionInterface
    {
        return new self(Foobar::of(), $this->collection);
    }

    // This example is intentionally incomplete.
    // For the sake of brevity, I did not added all the remaining
    // methods to satisfy the FoobarCollectionInterface.
}
