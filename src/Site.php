<?php
namespace Kizilare\Remote;

class Site
{
    public function getUrl( $url )
    {
        $curl_handler = curl_init( $url );

        // Returns headers with the response also.
        curl_setopt( $curl_handler, CURLOPT_HEADER, 1 );

        // Set the user agent.
        curl_setopt(
            $curl_handler,
            CURLOPT_USERAGENT,
            'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)'
        );

        // Get response instead of printing it directly.
        curl_setopt( $curl_handler, CURLOPT_RETURNTRANSFER, 1 );

        $result = curl_exec( $curl_handler );

        return $this->processResult( $result );
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