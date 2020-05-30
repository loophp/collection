<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Transformation\Run;

/**
 * Class Slice.
 */
final class Slice implements Operation
{
    /**
     * @var int|null
     */
    private $length;

    /**
     * @var int
     */
    private $offset;

    /**
     * Slice constructor.
     *
     * @param int $offset
     * @param int|null $length
     */
    public function __construct(int $offset, ?int $length = null)
    {
        $this->offset = $offset;
        $this->length = $length;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        $offset = $this->offset;
        $length = $this->length;

        return static function (iterable $collection) use ($offset, $length): Generator {
            $skip = new Skip($offset);

            if (null === $length) {
                return yield from (new Run($skip))($collection);
            }

            yield from (new Run($skip, new Limit($length)))($collection);
        };
    }
}
