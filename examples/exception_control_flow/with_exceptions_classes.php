<?php

namespace ts\Example\ExceptionControlFlow\With;

class ValueContainer extends \Exception
{
    private $value;

    public function __construct( $value )
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}

class Foo
{
    private $bar;

    public function getBar()
    {
        if ( !isset( $this->bar ) )
        {
            $this->calculateBar();
        }
        throw new ValueContainer( $this->bar );
    }

    private function calculateBar()
    {
        $this->bar = 52 - 29;
    }
}

class Bar
{
    private $foo;

    public function __construct( $foo )
    {
        $this->foo = $foo;
    }

    public function determineBar()
    {
        $this->foo->getBar();
    }
}

class Baz extends Bar
{
}

class Bam
{
    private $baz;

    private $result;

    public function __construct()
    {
        $this->baz = new Baz( new Foo() );
    }

    public function performOperation()
    {
        try
        {
            $this->baz->determineBar();
        }
        catch ( ValueContainer $e )
        {
            $this->result = $e->getValue();
        }
    }
}

?>
