<?php

namespace PHPaster\Paster;

/**
 * Paster for pastebin.com.
 * 
 * @package PHPaster
 * @version 
 * @copyright Copyright (C) 2010 Tobias Schlitt. All rights reserved.
 * @author Tobias Schlitt <toby@php.net> 
 * @license New BSD License
 */
class Pastebin implements \PHPaster\Paster
{
    /**
     * Pastebin API URL. 
     */
    const URL = 'http://pastebin.com/api_public.php';

    /**
     * Maps {@link \PHPaster\Paste} properties to API fields.
     * 
     * @var array(string=>string)
     */
    protected $apiMap = array(
        'title'   => 'paste_name',
        'content' => 'paste_code',
    );

    /**
     * HTTP client. 
     * 
     * @var \PHPaster\HttpClient
     */
    protected $httpClient;

    /**
     * Creates a new pastebin.com paster.
     * 
     * @param \PHPaster\HttpClient $httpClient 
     */
    public function __construct( \PHPaster\HttpClient $httpClient = null )
    {
        if ( $httpClient === null )
        {
            $httpClient = new \PHPaster\HttpClient();
        }
        $this->httpClient = $httpClient;
    }

    /**
     * Pastes the given $paste.
     * 
     * @param Paste $paste 
     * @param \PHPaster\HttpClient $httpClient 
     * @return string
     */
    public function paste( \PHPaster\Paste $paste )
    {
        $data = $this->extractPasteData( $paste );

        var_dump( $data );

        $res = $this->httpClient->post(
            self::URL,
            $data
        );

        return $res;
    }

    /**
     * Extracts API data from $paste.
     * 
     * @param Paste $paste 
     * @return array(string=>mixed)
     */
    protected function extractPasteData( \PHPaster\Paste $paste )
    {
        $data = array();
        foreach ( $this->apiMap as $from => $to )
        {
            $data[$to] = $paste->$from;
        }
        return $data;
    }
}

?>
