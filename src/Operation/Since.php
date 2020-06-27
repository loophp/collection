<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\IterableIterator;

final class Since extends AbstractOperation implements Operation
{
    public function __construct(callable ...$callbacks)
    {
        $this->storage['callbacks'] = $callbacks;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        return static function (iterable $collection, array $callbacks): Generator {
            $iterator = new IterableIterator($collection);

            while ($iterator->valid()) {
                $result = 1;

                foreach ($callbacks as $keyCallback => $callback) {
                    $result &= $callback($iterator->current(), $iterator->key());
                }

                if (1 === $result) {
                    break;
                }

                $iterator->next();
            }

            for (; $iterator->valid(); $iterator->next()) {
                yield $iterator->key() => $iterator->current();
            }
        };
    }
}
