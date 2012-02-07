<?php

require_once 'ezc/Base/base.php';

function simpleAutoload( $className )
{
    if ( substr( $className, 0, 8 ) === 'PHPaster' )
    {
        $file = __DIR__ . strtolower(
            str_replace(
                '\\',
                DIRECTORY_SEPARATOR,
                substr( $className, 8 )
            )
        ) . '.php';

        require $file;
    }
}

spl_autoload_register( 'simpleAutoload' );
spl_autoload_register( array( 'ezcBase', 'autoload' ) );

?>
