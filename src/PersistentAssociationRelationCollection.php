<?php

namespace Nassau\RelationCollection;

use Doctrine\ORM\PersistentCollection;

class PersistentAssociationRelationCollection extends RelationCollection
{

    public function __construct(PersistentCollection $collection)
    {
        $owner = $collection->getOwner();
        $method = 'set' . ($collection->getMapping()['inversedBy'] ?: $collection->getMapping()['mappedBy']);

        $association = function ($element) use ($owner, $method) {
            $element->{$method}($owner);
        };

        parent::__construct($association, $collection);
    }
}