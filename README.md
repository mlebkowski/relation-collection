# Doctrine Relation Collection

This Collection knows about their parent and sets it on an item when adding, .i.e:

```
$collection = $foo->getBars(); 
$collection->add($bar); // behind the scenes: $bar->setFoo($foo);
```

This way you can manage this relation via Symfony Forms without the ugly `by_reference` and `addBar()/removeBar()` methods.


## Requirements

You need to either:

 * wrap an initialized `PersistenCollection` with `PeristentAssociationRelationCollection` — works out of the box
 * use `RelationCollection` and tell it how to set the owner of an object using a closure. the former does 
   this automatically basing on mapping information retrieved from `PersistentCollection`



## Example usage

```php

class Foo {

    /**
     * @var Bar[]
     * @ORM\OneToMany(targetEntity="Bar", mappedBy="foo", cascade={"all"}, orphanRemoval=true)
     **/
    private $bars;
   
    public function getBars() {
        return new \Nassau\RelationCollection\PersistentAssociationRelationCollection($this->bars);
    }
    
    public function setBars($bars) {
        // noop, handled by reference, $this->getBars()->add($bar);
    }
}

```