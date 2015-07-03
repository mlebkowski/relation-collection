# Doctrine Relation Collection

This Collection knows about their parent and sets it on an item when adding, .i.e:

```
$collection = $foo->getBars(); 
$collection->add($bar); // behind the scenes: $bar->setFoo($foo);
```

This way you can manage this relation via Symfony Forms without the ugly `by_reference` and `addBar()/removeBar()` methods.


## Requirements

You need to either:

 * wrap an initialized `PersistentCollection` with `PeristentAssociationRelationCollection` — works out of the box
 * use `RelationCollection` and tell it how to set the owner of an object using a closure. the former does 
   this automatically basing on mapping information retrieved from `PersistentCollection`

## Why?

Because I don’t want to write adders/removers boilerplate for every relation. And also because of reasons. 

## Example usage

### With existing doctrine relations
 
```php
<?php

use Nassau\RelationCollection\PersistentAssociationRelationCollection;

/**
 * @ORM\Entity
 **/
class Foo {

    /**
     * @var Bar[]
     * @ORM\OneToMany(targetEntity="Bar", mappedBy="foo", cascade={"all"}, orphanRemoval=true)
     **/
    private $bars;
   
    public function getBars() {
        return new PersistentAssociationRelationCollection($this->bars);
    }
    
    public function setBars($bars) {
        // noop, handled by reference, $this->getBars()->add($bar);
    }
}

```

### Manually

```php
<?php

use Nassau\RelationCollection\RelationCollection;

class Foo {

    private $bars;
   
    public function __construct() {
        $this->bars = new RelationCollection(function (Bar $bar) {
            $bar->setFoo($this);
        });
    }
    
    public function getBars() {
        return $this->bars;
    }
    
}

class Bar {
    /** @var Foo */
    private $foo;
    
    public function setFoo(Foo $foo) {
        $this->foo = $foo;
    }
}

$foo = new Foo;

$foo->getBars()->add(new Bar);

```