<?php

namespace ts\Datastructures\Examples;

require_once __DIR__ . '/item.php';
require_once __DIR__ . '/test_base.php';

class TestMaintainList extends TestBase
{
    private $array;

    protected function setup()
    {
        $this->list = array();
    }

    protected function tearDown()
    {
        unset( $this->list );
    }

    protected function performAction()
    {
        parent::performAction();
    }

    protected function performSingleAction()
    {
        $this->list[] = $this->generateItem();
        if ( count( $this->list ) > 10 )
        {
            usort(
                $this->list,
                function ( $a, $b )
                {
                    return $a->compareTo( $b );
                }
            );
            array_pop( $this->list );
        }
    }
}

$bench = new TestMaintainList( 10 );
$bench->run();

var_dump( $bench->getAvgValues() );
var_dump( $bench->getStdDeviationValues() );

?>
