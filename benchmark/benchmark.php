<?php

namespace ts\Benchmark;

/**
 * Simple benchmark base class.
 */
abstract class Benchmark
{
    /**
     * Number of iterations to perform.
     * 
     * @var int
     */
    private $iterations;

    /**
     * Measured performance values.
     * 
     * @var array(string=>float)
     */
    private $values = array();

    /**
     * Average of performance values.
     * 
     * @var array(string=>floar)
     */
    private $avgValues;

    /**
     * Standard deviation of performance values. 
     * 
     * @var array(string=>float)
     */
    private $stdDeviationValues;

    /**
     * Sets up pre-condition of the action to measure.
     * 
     * @return void
     */
    protected abstract function setup();

    /**
     * Cleans up pre-conditions and generated data.
     * 
     * @return void
     */
    protected abstract function tearDown();

    /**
     * Performs the action to benchmark. 
     * 
     * @return void
     */
    protected abstract function performAction();

    /**
     * Creates a benchmark that will run $iterations times.
     * 
     * @param int $iterations 
     */
    public function __construct( $iterations = 1 )
    {
        $this->iterations = $iterations;
    }

    /**
     * Runs the benchmark.
     * 
     * @return void
     */
    public function run()
    {
        $this->clear();
        for ( $i = 0; $i < $this->iterations; ++$i )
        {
            $this->setup();
            $this->startMeasure( $i );
            $this->performAction();
            $this->stopMeasure( $i );
            $this->tearDown();
        }
    }

    /**
     * Returns the performance values for every iteration. 
     * 
     * @return array(int=>array(string=>float))
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Returns average performance values over all iterations.
     * 
     * @return array(string=>float)
     */
    public function getAvgValues()
    {
        if ( !isset( $this->avgValues ) )
        {
            $this->calculateAvgValues();
        }
        return $this->avgValues;
    }

    /**
     * Returns standard deviation of performance values over all iterations.
     * 
     * @return array(string=>float)
     */
    public function getStdDeviationValues()
    {
        if ( !isset( $this->stdDeviationValues ) )
        {
            $this->calculateStdDeviationValues();
        }
        return $this->stdDeviationValues;
    }

    /**
     * Calculates the average values and stores them.
     * 
     * @return void
     */
    private function calculateAvgValues()
    {
        $count = count( $this->values );

        $this->avgValues = array_map(
            function ( $v ) use ( $count )
            {
                return $v / $count;
            },
            array_reduce(
                $this->values,
                function ( $a, $b )
                {
                    return array(
                        'duration' => $a['duration'] + $b['duration'],
                        'memory'   => $a['memory']   + $b['memory'],
                    );
                }
            )
        );
    }

    /**
     * Calculates standard deviation values and stores them.
     * 
     * @return void
     */
    private function calculateStdDeviationValues()
    {
        $avg   = $this->getAvgValues();
        $count = count( $this->values );

        $this->stdDeviationValues = array_map(
            function ( $v ) use ( $count )
            {
                return sqrt( $v / $count );
            },
            array_reduce(
                array_map(
                    function ( $v ) use ( $avg )
                    {
                        return array(
                            'duration' => pow( $v['duration'] - $avg['duration'], 2 ),
                            'memory'   => pow( $v['memory'] - $avg['memory'], 2 ),
                        );
                    },
                    $this->values
                ),
                function ( $a, $b )
                {
                    return array(
                        'duration' => $a['duration'] + $b['duration'],
                        'memory'   => $a['memory'] + $b['memory'],
                    );
                }
            )
        );
    }

    /**
     * Start to measure performance for an $iteration.
     *
     * Initialilizes the value set for $iteration by taking the time and start 
     * memory usage.
     * 
     * @param int $iteration 
     * @return void
     */
    private function startMeasure( $iteration )
    {
        $this->values[$iteration] = array(
            'startTime'   => microtime( true ),
            'stopTime'    => null,
            'duration'    => null,
            'startMemory' => memory_get_usage(),
            'peakMemory'  => null,
            'memory'      => null,
        );
    }

    /**
     * Stops measuring and calculates performance of $iteration.
     *
     * Stops measuring and completes performance values for $iteration.
     * 
     * @param int $iteration 
     * @return void
     */
    private function stopMeasure( $iteration )
    {
        $this->values[$iteration]['stopTime']   = microtime( true );
        $this->values[$iteration]['peakMemory'] = memory_get_peak_usage();
        $this->values[$iteration]['duration']   = $this->values[$iteration]['stopTime'] - $this->values[$iteration]['startTime'];
        $this->values[$iteration]['memory']     = $this->values[$iteration]['peakMemory'] - $this->values[$iteration]['startMemory'];
    }

    /**
     * Clears the currently stored performance values.
     * 
     * @return void
     */
    private function clear()
    {
        $this->values             = array();
        $this->avgValues          = null;
        $this->stdDeviationValues = null;
    }
}

?>
