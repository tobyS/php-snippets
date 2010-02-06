<?php

namespace ts\Datastructures;

/**
 * Interface for comparable objects.
 */
interface Comparable
{
    /**
     * Compares the object to the given $value.
     *
     * Returns a positive integer, if the object is greater that the given 
     * $value, 0 if they are equal and a positive integer, if $value is greater 
     * than the object.
     *
     * Note that the method needs to check itself, if the given $value is of 
     * the same type as the object, to ensure that comparation is possible.
     * 
     * @param Comparable $value 
     * @return int
     */
    public function compareTo( Comparable $value );
}

?>
