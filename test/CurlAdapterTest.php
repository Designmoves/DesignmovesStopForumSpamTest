<?php

namespace DesignmovesStopForumSpamTest;

use PHPUnit_Framework_TestCase;
use Zend\Http\Client as ZendHttpClient;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ZendHttpClient
     */
    protected $httpClient;
  
    /**
     * @dataProvider providerUrls
     */
    public function testHttpClientWithoutCurlOptions($uri)
    {
        $config = [
            'adapter' => 'Zend\Http\Client\Adapter\Curl',
        ];
        $this->client = new ZendHttpClient($uri, $config);
        $this->client->send();

        $response = $this->client->getResponse();

        $this->assertContains('<root>', $response->getContent());
    }
    
    public function providerUrls()
    {
        return [
            ['http://www.stopforumspam.com/api?email=&ip=127.0.0.1&f=xmldom'],
        ];
    }
}
