<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\BoxPack;
use App\Services\BoxContainer;
use App\Services\Items;
use Illuminate\Support\Facades\Config;

class BoxPackTest extends TestCase
{
    private BoxPack $boxPack;

    protected function setUp(): void
    {
        parent::setUp();
        $this->boxPack = new BoxPack();

        // Set up the box configuration
        Config::set('boxes', [
            ['name' => 'BOXA', 'length' => 20, 'width' => 15, 'height' => 10, 'weight_limit' => 5],
            ['name' => 'BOXB', 'length' => 30, 'width' => 25, 'height' => 20, 'weight_limit' => 10],
            ['name' => 'BOXC', 'length' => 60, 'width' => 55, 'height' => 50, 'weight_limit' => 50],
            ['name' => 'BOXD', 'length' => 50, 'width' => 45, 'height' => 40, 'weight_limit' => 30],
            ['name' => 'BOXE', 'length' => 40, 'width' => 35, 'height' => 30, 'weight_limit' => 20],
        ]);
    }

    public function testSetBoxes()
    {
        $boxConfigurations = Config::get('boxes');
        $this->boxPack->setBoxes($boxConfigurations);

        $this->assertCount(5, $this->getPrivateProperty($this->boxPack, 'boxes'));
    }

    public function testAddItem()
    {
        $item = new Items('Test Item', 5, 5, 5, 1, 1);
        $this->boxPack->addItem($item);

        $this->assertCount(1, $this->getPrivateProperty($this->boxPack, 'items'));
    }

    public function testPack()
    {
        $boxConfigurations = Config::get('boxes');
        $this->boxPack->setBoxes($boxConfigurations);

        $item1 = new Items('2Kg Rice Packaage', 10, 10, 5, 2, 2);
        $item2 = new Items('8kg Exercise Weights', 25, 20, 15, 8, 1); 
        $item3 = new Items('Large Tire', 55, 50, 45, 25, 1);

        $this->boxPack->addItem($item1);
        $this->boxPack->addItem($item2);
        $this->boxPack->addItem($item3);

        $packedBoxes = $this->boxPack->pack();

        $this->assertCount(1, $packedBoxes);
        $this->assertEquals('BOXC', $packedBoxes[0]['box']->name);
        $this->assertCount(3, $packedBoxes[0]['items']);
    }

    private function getPrivateProperty($object, $propertyName)
    {
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        return $property->getValue($object);
    }
}