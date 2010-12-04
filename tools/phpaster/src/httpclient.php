<?php

namespace PHPaster;

class HttpClient
{
    /**
     * Sends a POST request with $data to $url and returns the response.
     *
     * Receives an optional array of $headers. $data may be a string, which is 
     * sent as is, an array or an object, then it is mangled using {@link 
     * http_build_query()}. Returns the response body.
     * 
     * @param string $url 
     * @param string|array|object $data 
     * @param array(string=>string) $headers 
     * @return string
     */
    public function post( $url, $data, array $headers = array() )
    {
        $streamParams = array(
            'http' => array(
                'method'  => 'POST',
                'content' => ( !is_scalar( $data )
                    ? http_build_query( $data )
                    : (string) $data
                ),
                'header'  => $this->mergeHeaders( $headers ),
            ),
        );

        $streamCtx = stream_context_create( $streamParams );

        $fp = fopen( $url, 'rb', false, $streamCtx );

        if ( false === $fp )
        {
            throw new RuntimeException( 'Could not connect to service.' );
        }

        $res = stream_get_contents( $fp );

        if ( false === $res )
        {
            throw new RuntimeException( 'Could not read from stream.' );
        }

        return $res;
    }

    /**
     * Merges the headers array to a string.
     * 
     * @param array $headers 
     * @return string
     */
    protected function mergeHeaders( array $headers )
    {
        $headerString = '';
        foreach ( $headers as $key => $val )
        {
            $headerString .= sprintf(
                "%s: %s\n",
                $key,
                $val
            );
        }
        return $headerString;
    }
}

?>
