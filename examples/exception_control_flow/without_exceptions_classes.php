<?php

namespace ts\Example\ExceptionControlFlow\Without;

class Foo
{
    private $bar;

    public function getBar()
    {
        if ( !isset( $this->bar ) )
        {
            $this->calculateBar();
        }
        return $this->bar;
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
        return $this->foo->getBar();
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
        $this->result = $this->baz->determineBar();
    }
}

$bam = new Bam();
$bam->performOperation();

var_dump( $bam );

?>
