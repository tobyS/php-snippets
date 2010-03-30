<?php

require_once __DIR__ . '/../../benchmark/benchmark.php';
require_once __DIR__ . '/with_exceptions_classes.php';

class Test extends \ts\Benchmark\Benchmark
{

    protected $bam;

    protected function setup()
    {
        $this->bam = new \ts\Example\ExceptionControlFlow\With\Bam();
    }

    protected function tearDown()
    {
        unset( $this->bam );
    }

    protected function performAction()
    {
        $this->bam->performOperation();
    }
}

$test =  new Test( 10000 );
$test->run();

var_dump( $test->getAvgValues() );

?>
