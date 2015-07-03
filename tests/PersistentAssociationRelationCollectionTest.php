<?php

namespace Nassau\RelationCollection;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\PersistentCollection;
use Nassau\RelationCollection\Stub\Bar;
use Nassau\RelationCollection\Stub\Foo;

class PersistentAssociationRelationCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testAssociationCallbackIsCreatedFromPersistenCollection()
    {
        $owner = new Foo();
        $item = new Bar();

        $mapping = [
            'mappedBy' => 'foo',
            'inversedBy' => 'foo',
            // some shit so PersistentCollection doesn’t crash
            'isOwningSide' => true,
            'type' => null
        ];

        $persistentCollection = new PersistentCollection(
            $this->getMockBuilder(EntityManagerInterface::class)->disableOriginalConstructor()->getMock(),
            $this->getMockBuilder(ClassMetadata::class)->disableOriginalConstructor()->getMock(),
            new ArrayCollection()
        );

        $persistentCollection->setOwner($owner, $mapping);


        $collection = new PersistentAssociationRelationCollection($persistentCollection);

        $collection->add($item);

        $this->assertSame($owner, $item->getFoo());
    }
}
