<?php

if ( !isset( $argv[1] ) )
{
    die( "Missing directory to work on.\n" );
}

$targetDir = $argv[1];

if ( !is_dir( $targetDir ) )
{
    die( "Couldn't find target dir '$targetDir'.\n" );
}

$fileItr = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(
        $targetDir,
        FilesystemIterator::CURRENT_AS_FILEINFO
            | FilesystemIterator::KEY_AS_PATHNAME
            | FilesystemIterator::SKIP_DOTS
    ),
    RecursiveIteratorIterator::CHILD_FIRST
);

foreach ( $fileItr as $path => $fileInfo )
{
    $newName = iconv(
        'UTF-8',
        'Latin1//TRANSLIT',
        preg_replace(
            array(
                '(\([^\)]*\)|^_+|_+$)',
                '(([_-])+)',
                '(_+.mp3$)'
            ),
            array(
                '',
                '${1}',
                '.mp3'
            ),
            strtr( $fileInfo->getBasename(), array( ' ' => '_', '+' => '_', '&' => '-' ) )
        )
    );

    $newPath = $fileInfo->getPath();

    for ( $i = $fileItr->getDepth(); $i > 1; --$i )
    {
        $newName = basename( $newPath ) . '_' . $newName;
        $newPath = dirname( $newPath );
    }

    echo $newPath . '/' . $newName . "\n";

    if ( $fileInfo->isFile() && strlen( $newName ) > 204 )
    {
        $newName = substr( $newName, 0, 200 ) . '.' . substr( $newName, -3 );
    }

    if ( $fileInfo->isDir() && $fileItr->getDepth() > 1 )
    {
        rmdir( $path );
    }
    else if ( $fileInfo->isFile() && substr( $fileInfo->getBasename(), -3 ) !== 'mp3' )
    {
        unlink( $path );
    }
    else
    {
        rename( $path, $newPath . '/' . $newName );
    }
}

?>
