<?php

namespace Nassau\RelationCollection\Stub;

class Bar 
{
    /**
     * @var Foo
     */
    private $foo;

    /**
     * @return Foo
     */
    public function getFoo()
    {
        return $this->foo;
    }

    /**
     * @param Foo $foo
     *
     * @return $this
     */
    public function setFoo(Foo $foo)
    {
        $this->foo = $foo;

        return $this;
    }

}