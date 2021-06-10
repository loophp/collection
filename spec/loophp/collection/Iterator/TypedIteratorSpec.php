<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\loophp\collection\Iterator;

use ArrayIterator;
use Countable;
use Generator;
use InvalidArgumentException;
use JsonSerializable;
use loophp\collection\Iterator\TypedIterator;
use PhpSpec\ObjectBehavior;
use stdClass;
use function gettype;

class TypedIteratorSpec extends ObjectBehavior
{
    private const LIST_DATA = [1, 2, 3];

    private const MAP_DATA = ['foo' => 1, 'bar' => 2];

    public function it_allows_array_of_any_type(): void
    {
        $data = [self::MAP_DATA, self::LIST_DATA];

        $this->beConstructedWith($data);

        $this->shouldIterateAs($data);
    }

    public function it_allows_custom_gettype_callback(): void
    {
        $callback = static fn ($variable) => gettype($variable);

        $obj1 = new class() {
            public function sayHello(): string
            {
                return 'Hello';
            }
        };
        $obj2 = new stdClass();

        $data = [new $obj1(), new $obj2()];

        $this->beConstructedWith($data, $callback);

        $this->shouldIterateAs($data);
    }

    public function it_allows_different_classes_with_multiple_interfaces(): void
    {
        $obj1 = new class() implements Countable, JsonSerializable {
            public function count(): int
            {
                return 0;
            }

            public function jsonSerialize(): string
            {
                return '';
            }
        };

        $obj2 = new class() implements Countable, JsonSerializable {
            public function count(): int
            {
                return 0;
            }

            public function jsonSerialize(): string
            {
                return '';
            }
        };

        $data = [new $obj1(), new $obj2()];

        $this->beConstructedWith($data);

        $this->shouldIterateAs($data);
    }

    public function it_allows_different_classes_with_same_interface(): void
    {
        $obj1 = new class() implements Countable {
            public function count(): int
            {
                return 0;
            }
        };

        $obj2 = new class() implements Countable {
            public function count(): int
            {
                return 0;
            }
        };

        $data = [new $obj1(), new $obj2()];

        $this->beConstructedWith($data);

        $this->shouldIterateAs($data);
    }

    public function it_allows_null_type(): void
    {
        $data = [1, null, 3];

        $this->beConstructedWith($data);

        $this->shouldIterateAs($data);
    }

    public function it_allows_same_class_with_interface(): void
    {
        $obj = new class() implements Countable {
            public function count(): int
            {
                return 0;
            }
        };

        $data = [new $obj(), new $obj()];

        $this->beConstructedWith($data);

        $this->shouldIterateAs($data);
    }

    public function it_allows_same_class_with_multiple_interfaces(): void
    {
        $obj = new class() implements Countable, JsonSerializable {
            public function count(): int
            {
                return 0;
            }

            public function jsonSerialize(): string
            {
                return '';
            }
        };

        $data = [new $obj(), new $obj()];

        $this->beConstructedWith($data);

        $this->shouldIterateAs($data);
    }

    public function it_allows_same_class_without_interface(): void
    {
        $obj1 = new stdClass();
        $obj1->id = 1;

        $obj2 = new stdClass();
        $obj2->id = 2;

        $data = [$obj1, $obj2];

        $this->beConstructedWith($data);

        $this->shouldIterateAs($data);
    }

    public function it_can_return_a_string_key(): void
    {
        $this->beConstructedWith(self::MAP_DATA);

        $this->key()->shouldBe('foo');
        $this->next();
        $this->key()->shouldBe('bar');
    }

    public function it_can_return_an_int_key(): void
    {
        $this->beConstructedWith(self::LIST_DATA);

        $this->key()->shouldBe(0);
        $this->next();
        $this->key()->shouldBe(1);
    }

    public function it_can_rewind(): void
    {
        $this->beConstructedWith(['foo']);

        $this->current()->shouldBe('foo');

        $this->next();
        $this->valid()->shouldBe(false);
        $this->current()->shouldBeNull();

        $this->rewind();
        $this->valid()->shouldBe(true);
        $this->current()->shouldBe('foo');
    }

    public function it_disallows_bool_mixed(): void
    {
        $this->beConstructedWith([true, false, 'bar']);

        $this->next();

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_different_classes(): void
    {
        $obj1 = new class() {
            public function sayHello(): string
            {
                return 'Hello';
            }
        };

        $obj2 = new stdClass();

        $data = [new $obj1(), new $obj2()];

        $this->beConstructedWith($data);

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_float_mixed(): void
    {
        $this->beConstructedWith([2.3, 5.6, 1]);

        $this->next();

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_int_mixed(): void
    {
        $this->beConstructedWith([1, 2, 'foo']);

        $this->next();

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_mix_of_classes_with_and_without_interfaces(): void
    {
        $obj1 = new class() implements Countable {
            public function count(): int
            {
                return 0;
            }
        };

        $obj2 = new class() {
            public function count(): int
            {
                return 0;
            }
        };

        $data = [new $obj1(), new $obj2()];

        $this->beConstructedWith($data);

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_mix_of_classes_with_different_interfaces(): void
    {
        $obj1 = new class() implements Countable {
            public function count(): int
            {
                return 0;
            }
        };

        $obj2 = new class() implements JsonSerializable {
            public function jsonSerialize(): string
            {
                return '';
            }
        };

        $data = [new $obj1(), new $obj2()];

        $this->beConstructedWith($data);

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_mixed_at_beginning(): void
    {
        $this->beConstructedWith([1, 'bar', 'foo']);

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_mixed_in_middle(): void
    {
        $this->beConstructedWith([1, 'bar', 2]);

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_resource_mixed_open_closed(): void
    {
        $openResource = fopen('data://text/plain,ABCD', 'rb');
        $closedResource = fopen('data://text/plain,XYZ', 'rb');
        fclose($closedResource);

        $this->beConstructedWith([$openResource, $closedResource]);

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_disallows_string_mixed(): void
    {
        $this->beConstructedWith(['foo', 'bar', 3]);

        $this->next();

        $this->shouldThrow(InvalidArgumentException::class)->during('next');
    }

    public function it_is_initializable_from_array(): void
    {
        $this->beConstructedWith(self::LIST_DATA);

        $this->shouldHaveType(TypedIterator::class);

        $this->valid()->shouldBe(true);
        $this->shouldIterateAs(self::LIST_DATA);
    }

    public function it_is_initializable_from_generator(): void
    {
        $gen = static fn (): Generator => yield from self::MAP_DATA;

        $this->beConstructedWith($gen());

        $this->shouldHaveType(TypedIterator::class);

        $this->valid()->shouldBe(true);
        $this->shouldIterateAs(self::MAP_DATA);
    }

    public function it_is_initializable_from_iterator(): void
    {
        $this->beConstructedWith(new ArrayIterator(self::LIST_DATA));

        $this->shouldHaveType(TypedIterator::class);

        $this->valid()->shouldBe(true);
        $this->shouldIterateAs(self::LIST_DATA);
    }
}
