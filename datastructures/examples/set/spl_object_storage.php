<?php

namespace ts\Datastructures\Examples;

use \SplObjectStorage, \stdClass;

$set = new SplObjectStorage();

$o1 = new stdClass();
$o1->id = 23;

$o2 = new stdClass();
$o2->id = 42;

$o3 = new stdClass();
$o3->id = 23;

$set->attach( $o1 );
$set->attach( $o2 );

echo "The set contains ", count( $set ), " objects\n";

$set->attach( $o1 );

echo "The set contains ", count( $set ), " objects\n";

$set->attach( $o3 );

echo "The set contains ", count( $set ), " objects\n";

$set1 = new SplObjectStorage();
$set2 = new SplObjectStorage();

$set1->attach( $o1 );
$set1->attach( $o2 );

$set2->attach( $o2 );
$set2->attach( $o3 );

echo "Set 1 contains ", count( $set1 ), " objects\n";
echo "Set 2 contains ", count( $set2 ), " objects\n";

$set3 = clone $set1;
$set3->addAll( $set2 );

echo "Set 3 contains ", count( $set3 ), " objects\n";

$set4 = clone $set1;
$set4->removeAll( $set2 );

echo "Set 4 contains ", count( $set4 ), " objects\n";

?>
