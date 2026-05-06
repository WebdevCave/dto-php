<?php

namespace Webdevcave\DTO\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Webdevcave\DTO\DataTransferObject;

class ChildDTO extends DataTransferObject
{
    public function __construct(
        public string $name
    ) {
    }
}

class ParentDTO extends DataTransferObject
{
    public function __construct(
        public string $name,
        public ChildDTO $child
    ) {
    }
}

#[CoversClass(DataTransferObject::class)]
class DataTransferObjectTest extends TestCase
{
    public function testHydration(): void
    {
        $data = [
            'name' => 'John Doe',
            'child' => [
                'name' => 'Jane Doe',
            ],
        ];

        $parent = ParentDTO::from($data);

        $this->assertInstanceOf(ParentDTO::class, $parent);
        $this->assertEquals('John Doe', $parent->name);
        $this->assertInstanceOf(ChildDTO::class, $parent->child);
        $this->assertEquals('Jane Doe', $parent->child->name);
    }

    public function testArrayAccess(): void
    {
        $data = ['name' => 'John Doe'];
        $dto = ChildDTO::from($data);

        // offsetExists
        $this->assertTrue(isset($dto['name']));
        $this->assertFalse(isset($dto['age']));

        // offsetGet
        $this->assertEquals('John Doe', $dto['name']);

        // offsetSet
        $dto['name'] = 'Jane Doe';
        $this->assertEquals('Jane Doe', $dto->name);

        // offsetUnset (Note: This might fail or behave unexpectedly if property is not nullable/optional)
        unset($dto['name']);
        $this->assertFalse(isset($dto->name));
    }

    public function testSerialization(): void
    {
        $data = [
            'name' => 'John Doe',
            'child' => [
                'name' => 'Jane Doe',
            ],
        ];

        $parent = ParentDTO::from($data);

        $expectedArray = $data;
        $this->assertEquals($expectedArray, $parent->toArray());

        $expectedJson = json_encode($expectedArray);
        $this->assertEquals($expectedJson, $parent->toJson());
        $this->assertEquals($expectedJson, json_encode($parent));
    }

    public function testStaticContainer(): void
    {
        // Accessing private static container via from() multiple times
        // to ensure it works correctly when initialized.
        $dto1 = ChildDTO::from(['name' => 'Test 1']);
        $dto2 = ChildDTO::from(['name' => 'Test 2']);

        $this->assertEquals('Test 1', $dto1->name);
        $this->assertEquals('Test 2', $dto2->name);
    }
}
