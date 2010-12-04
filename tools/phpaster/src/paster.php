<?php

namespace PHPaster;

/**
 * Interface for pasters.
 * 
 * @package PHPaster
 * @version 
 * @copyright Copyright (C) 2010 Tobias Schlitt. All rights reserved.
 * @author Tobias Schlitt <toby@php.net> 
 * @license New BSD License
 */
interface Paster
{
    /**
     * Performs a paste.
     * 
     * @param Paste $paste 
     * @return string The paste URL
     */
    public function paste( Paste $paste );
}

?>
