<?php

namespace PHPaster;

/**
 * Struct class representing a paste.
 * 
 * @property string $title Title of the paste.
 * @property string $content Content of the paste.
 * @property string $author Author name.
 *
 * @package PHPaster
 * @version 
 * @copyright Copyright (C) 2010 Tobias Schlitt. All rights reserved.
 * @author Tobias Schlitt <toby@php.net> 
 * @license New BSD License
 */
class Paste
{
    /**
     * Properties.
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array(
        'title'   => '',
        'content' => '',
        'author'  => '',
    );

    /**
     * Creates a new paste with the given $content.
     * 
     * @param string $content 
     */
    public function __construct( $content )
    {
        $this->content = $content;
    }

    /**
     * Property isset().
     * 
     * @param string $propertyName 
     * @return bool
     */
    public function __isset( $propertyName )
    {
        return ( array_key_exists( $propertyName, $this->properties ) );
    }

    /**
     * Property get.
     * 
     * @param string $propertyName 
     * @return mixed
     */
    public function __get( $propertyName )
    {
        if ( $this->__isset( $propertyName ) )
        {
            return $this->properties[$propertyName];
        }
        throw new InavlidArgumentException( "Property '{$propertyName}' does not exist." );
    }

    /**
     * Property set.
     * 
     * @param string $propertyName 
     * @param mixed $propertyValue 
     * @return void
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'title':
            case 'author':
            case 'content':
                if ( !is_string( $propertyValue ) )
                {
                    throw new InavlidArgumentException(
                        "Property '{$propertyName}' expected to be string."
                    );
                }
                break;

            default:
                throw new InavlidArgumentException(
                    "Property '{$propertyName}' does not exist."
                );
        }

        $this->properties[$propertyName] = $propertyValue;
    }
}

?>
