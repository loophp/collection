<?php

declare(strict_types=1);

namespace loophp\collection;

use Closure;
use Generator;
use loophp\collection\Contract\Base as BaseInterface;
use loophp\collection\Contract\Operation;
use loophp\collection\Contract\Transformation;
use loophp\collection\Iterator\ClosureIterator;
use loophp\collection\Transformation\Run;
use loophp\collection\Transformation\Transform;

use function is_resource;
use function is_string;

abstract class Base implements BaseInterface
{
    /**
     * @var Closure
     */
    protected $source;

    /**
     * Base constructor.
     *
     * @param Closure|iterable|mixed|resource|string $data
     * @param mixed ...$parameters
     */
    final public function __construct($data = [], ...$parameters)
    {
        switch (true) {
            case is_resource($data) && 'stream' === get_resource_type($data):
                $this->source = static function () use ($data): Generator {
                    while (false !== $chunk = fgetc($data)) {
                        yield $chunk;
                    }
                };

                break;
            case $data instanceof Closure:
                $this->source = static function () use ($data, $parameters): Generator {
                    yield from $data(...$parameters);
                };

                break;
            case is_iterable($data):
                $this->source = static function () use ($data): Generator {
                    foreach ($data as $key => $value) {
                        yield $key => $value;
                    }
                };

                break;
            case is_string($data):
                $parameters += [0 => null];
                $separator = (string) $parameters[0];

                $this->source = static function () use ($data, $separator): Generator {
                    $offset = 0;

                    $nextOffset = '' !== $separator ?
                        mb_strpos($data, $separator, $offset) :
                        1;

                    while (mb_strlen($data) > $offset && false !== $nextOffset) {
                        yield mb_substr($data, $offset, $nextOffset - $offset);
                        $offset = $nextOffset + mb_strlen($separator);

                        $nextOffset = '' !== $separator ?
                            mb_strpos($data, $separator, $offset) :
                            $nextOffset + 1;
                    }

                    if ('' !== $separator) {
                        yield mb_substr($data, $offset);
                    }
                };

                break;

            default:
                $this->source = static function () use ($data): Generator {
                    foreach ((array) $data as $key => $value) {
                        yield $key => $value;
                    }
                };
        }
    }

    public function getIterator(): ClosureIterator
    {
        return new ClosureIterator($this->source);
    }

    /**
     * {@inheritdoc}
     */
    public function run(Operation ...$operations)
    {
        return new static((new Run(...$operations))($this));
    }

    /**
     * {@inheritdoc}
     */
    public function transform(Transformation ...$transformers)
    {
        return (new Transform(...$transformers))($this);
    }
}
