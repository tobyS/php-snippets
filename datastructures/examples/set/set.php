<?php

namespace ts\Datastructures\Examples;

require_once __DIR__ . '/../../math/set.php';

use \ts\Datastructures\Math\Set;
use \stdClass;

$o1 = new stdClass();
$o1->id = 23;

$o2 = new stdClass();
$o2->id = 42;

$o3 = new stdClass();
$o3->id = 23;

$o4 = new stdClass();
$o4->id = 1337;

$set1 = new Set();
$set1->attach( $o1 );
$set1->attach( $o2 );
$set1->attach( $o4 );

$set2 = new Set();
$set2->attach( $o2 );
$set2->attach( $o3 );

echo "Union of set 1 and 2 contains ", count( $set1->union( $set2 ) ), " objects\n";
echo "Intersection of set 1 and 2 contains ", count( $set1->intersect( $set2 ) ), " objects.\n";
echo "Set 1 minus set 2 contains ", count( $set1->subtract( $set2 ) ), " objects\n";
echo "The symmetric difference of set 1 and 2 contains ", count( $set1->symmetricDifference( $set2 ) ), " objects.\n";

?>
