<?php
namespace Kizilare\Remote;

class Site
{
    /**
     * Number of timeout seconds for connection.
     *
     * @var integer
     */
    protected $connection_timeout = 5;

    /**
     * Number of second for process.
     *
     * @var integer
     */
    protected $timeout = 10;

    /**
     * User agent sent to the remote server.
     *
     * @var string
     */
    protected $user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';

    public function getUrl( $url )
    {
        $curl_handler = curl_init( $url );

        curl_setopt( $curl_handler, CURLOPT_HEADER, 1 );
        curl_setopt( $curl_handler, CURLOPT_USERAGENT, $this->user_agent );
        curl_setopt( $curl_handler, CURLOPT_CONNECTTIMEOUT, $this->connection_timeout );
        curl_setopt( $curl_handler, CURLOPT_TIMEOUT, $this->timeout );
        curl_setopt( $curl_handler, CURLOPT_RETURNTRANSFER, 1 );

        $result = curl_exec( $curl_handler );

        return $this->processResult( $result );
    }

    /**
     * @param string $user_agent
     */
    public function setUserAgent( $user_agent )
    {
        $this->user_agent = $user_agent;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout( $timeout )
    {
        $this->timeout = $timeout;
    }

    /**
     * @param int $connection_timeout
     */
    public function setConnectionTimeout( $connection_timeout )
    {
        $this->connection_timeout = $connection_timeout;
    }

    protected function processResult( $response )
    {
        $lines = explode( "\n", $response );
        $headers = array();
        while (!empty( $lines )) {
            $line = trim( array_shift( $lines ) );
            if (empty( $line )) {
                break;
            }
            $headers[] = $line;

        }
        $data = implode( "\n", $lines );
        return array( 'headers' => $headers, 'response' => $data );
    }
}