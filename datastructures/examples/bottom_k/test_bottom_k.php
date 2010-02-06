<?php

namespace ts\Datastructures\Examples;

require_once __DIR__ . '/../../bottom_k.php';
require_once __DIR__ . '/item.php';
require_once __DIR__ . '/test_base.php';

class TestBottomK extends TestBase
{
    private $heap;

    protected function setup()
    {
        $this->heap = new \ts\Datastructures\BottomK( 10 );
    }

    protected function tearDown()
    {
        unset( $this->heap );
    }

    protected function performSingleAction()
    {
        $this->heap->insert( $this->generateItem() );
    }
}

$bench = new TestBottomK( 10 );
$bench->run();

var_dump( $bench->getAvgValues() );
var_dump( $bench->getStdDeviationValues() );

?>
