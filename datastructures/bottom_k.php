<?php

namespace ts\Datastructures;

/**
 * Datastructure to keep bottom k elements.
 * 
 * This data structure keeps a limited number of objects available, which are 
 * the smallest of their kind (in respect to {@link tsDatastructureComparable}).
 */
class BottomK extends \SplMaxHeap
{
    /**
     * Number of objects to keep.
     * 
     * @var int
     */
    protected $limit;

    /**
     * Creates a new max heap with $limit.
     *
     * Only $limit number of objects will be kept in the heap.
     * 
     * @param int $limit 
     */
    public function __construct( $limit )
    {
        $this->limit = (int) $limit;
    }

    /**
     * Compare values $a and $b.
     *
     * Compares $a with $b using {@link tsDatastructureComparable::compareTo()} 
     * and returns the value.
     * 
     * @param tsDatastructureComparable $a 
     * @param tsDatastructureComparable $b 
     * @return int
     * @throws RuntimeException if $a is not an instance of {@link 
     *         tsDatastructureComparable}.
     */
    public function compare( $a, $b )
    {
        if ( !( $a instanceof Comparable ) )
        {
            throw new RuntimeException(
                'Value a must implement ttpDatastructureComparable.'
            );
        }
        return $a->compareTo( $b );
    }

    /**
     * Insert $value into the heap and keep the size limit.
     * 
     * @param tsDatastructureComparable $value 
     * @return void
     */
    public function insert( $value )
    {
        parent::insert( $value );

        while ( count( $this ) > $this->limit )
        {
            $this->extract();
        }
    }
}

?>
