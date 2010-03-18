<?php

namespace ts\Datastructures\Math;

class Set extends \SplObjectStorage
{
    /**
     * Returns the union of the 2 sets.
     * 
     * @param Set $secondSet 
     * @return Set
     */
    public function union( Set $secondSet )
    {
        $res = clone $this;
        $res->addAll( $secondSet );
        return $res;
    }

    /**
     * Returns the intersection of the 2 sets. 
     * 
     * @param Set $secondSet 
     * @return Set
     */
    public function intersect( Set $secondSet )
    {
        $intermed = $this->subtract( $secondSet );
        $res = clone $this;
        $res->removeAll( $intermed );
        return $res;
    }

    /**
     * Returns the set minus $secondSet. 
     * 
     * @param Set $secondSet 
     * @return Set
     */
    public function subtract( Set $secondSet )
    {
        $res = clone $this;
        $res->removeAll( $secondSet );
        return $res;
    }

    /**
     * Returns the symmetric difference of the set an $secondSet. 
     * 
     * @param Set $secondSet 
     * @return Set
     */
    public function symmetricDifference( Set $secondSet )
    {
        $onlyFirst = $this->subtract( $secondSet );
        $onlySecond = $secondSet->subtract( $this );
        return $onlyFirst->union( $onlySecond );
    }
}

?>
