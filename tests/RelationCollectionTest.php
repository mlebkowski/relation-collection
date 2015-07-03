<?php

namespace Nassau\RelationCollection;

use Nassau\RelationCollection\Stub\Bar;
use Nassau\RelationCollection\Stub\Foo;

class RelationCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testOwnerIsSetWhenAddingToCollection()
    {
        $owner = new Foo();
        $item = new Bar();


        $association = function (Bar $bar) use ($owner) {
            $bar->setFoo($owner);
        };

        $collection = new RelationCollection($association);

        $collection->add($item);

        $this->assertSame($owner, $item->getFoo());
    }
}
