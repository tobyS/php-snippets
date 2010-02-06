<?php

namespace ts\Datastructures\Examples;

require_once __DIR__ . '/../../interfaces/comparable.php';

class Item implements \ts\Datastructures\Comparable
{
    private $value;

    public function __construct( $value )
    {
        $this->value = (int) $value;
    }

    public function compareTo( \ts\Datastructures\Comparable $object )
    {
        if ( $this->value > $object->value )
        {
            return 1;
        }
        if ( $this->value < $object->value )
        {
            return -1;
        }
        return 0;
    }
}

?>
