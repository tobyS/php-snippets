<?php

namespace ts\Datastructures\Examples;

require_once __DIR__ . '/../../../benchmark/benchmark.php';

abstract class TestBase extends \ts\Benchmark\Benchmark
{
    protected function generateItem ()
    {
        return new Item( mt_rand( 0, PHP_INT_MAX ) );
    }

    protected function performAction()
    {
        for ( $i = 0; $i < 10000; ++$i )
        {
            $this->performSingleAction();
        }
    }

    protected abstract function performSingleAction();
}

?>
