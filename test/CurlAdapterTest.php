<?php

namespace DesignmovesStopForumSpamTest;

use PHPUnit_Framework_TestCase;
use Zend\Http\Client as ZendHttpClient;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test native PHP cURL as reference
     * 
     * @dataProvider providerUrls
     */
    public function testNativeCurl($uri)
    {
        $cUrl = curl_init();
        curl_setopt_array($cUrl, [
            CURLOPT_URL            => $uri,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        
        $content = curl_exec($cUrl);  

        $this->assertContains('<root>', $content);
    }
  
    /**
     * @dataProvider providerUrls
     */
    public function testHttpClientWithCURLOPT_ENCODING($uri)
    {
        $config = [
            'adapter'     => 'Zend\Http\Client\Adapter\Curl',
            'curloptions' => [
                CURLOPT_ENCODING => '',
            ],
        ];
        $client = new ZendHttpClient($uri, $config);
        $client->send();

        $response = $client->getResponse();

        $this->assertContains('<root>', $response->getContent());
    }
    
    /**
     * @dataProvider providerUrls
     */
    public function testHttpClientWithoutCURLOPT_ENCODING($uri)
    {
        $config = [
            'adapter' => 'Zend\Http\Client\Adapter\Curl',
        ];
        $client = new ZendHttpClient($uri, $config);
        $client->send();

        $response = $client->getResponse();

        $this->assertContains('<root>', $response->getContent());
    }
    
    public function providerUrls()
    {
        return [
            ['http://www.stopforumspam.com/api?email=&ip=127.0.0.1&f=xmldom'],
        ];
    }
}
