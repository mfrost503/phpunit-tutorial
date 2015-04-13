<?php
namespace Tutorial\Tests\Mocking\API;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Message\Response;
use Tutorial\Mocking\API\Slack;
use PHPUnit_Framework_TestCase;
/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @package tests
 * @subpackage Mocking
 * @subpackage API
 * @license MIT http://opensource.org/licenses/MIT
 */
class SlackTest extends PHPUnit_Framework_TestCase
{
    /**
     * @const string
     */
    const BASEURL = 'https://slack.com/api/';

    /**
     * @var GuzzleHttp\Message\Response
     */
    private $response;

    /**
     * @var GuzzleHttp\Client 
     */
    private $client;

    /**
     * @var string
     */
    private $token;

    /**
     * Set up - runs before each test
     */
    protected function setUp()
    {
        $this->client = $this->getMock('\GuzzleHttp\Client', ['post', 'get']);
        $this->token = '123ABCDEF456';
        $this->response = $this->getMockBuilder('\GuzzleHttp\Message\Response')
            ->disableOriginalConstructor()
            ->setMethods( ['getBody'])
            ->getMock();
        $this->clientException = $this->getMockBuilder('\GuzzleHttp\Exception\ClientException')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Tear down - runs after each test
     */
    protected function tearDown()
    {
        unset($this->client);
        unset($this->token);
        unset($this->response);
        unset($this->clientException);
    }

    /**
     * Test to ensure that getChannels returns a list of channels
     * Using a fixture to read in a fake response
     */
    public function testEnsureGetChannelsReturnsListOfChannels()
    {
        // read the data fixture in from filesystem
        $fh = fopen('tests/Mocking/API/Fixtures/channel-list.txt', 'r');
        $response = fread($fh, 4096);
        fclose($fh);  

        $url = self::BASEURL . 'channels.list';
        $bodyParam = [
            'body' => [
                'token' => $this->token
            ]
        ];

        $this->client->expects($this->once())
            ->method('post')
            ->with($url, $bodyParam)
            ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($response));

        $slack = new Slack($this->client, $this->token);
        $result = $slack->retrieveChannels();

        $arrayResponse = json_decode($result, true);
        $this->assertTrue($arrayResponse['ok']);
        $this->assertEquals($arrayResponse['channels'][0]['name'], 'deployments');
    }

    /**
     * Test to ensure message is able to be sent correctly
     */
    public function testEnsureMessageCanBeSent()
    {
        // Set up the data fixture
        $fh = fopen('tests/Mocking/API/Fixtures/send-data.txt', 'r');
        $response = fread($fh, 4096);
        fclose($fh);

        $channel = 'C04C8KJRC';
        $text = 'This is a test';
        $url = self::BASEURL . 'chat.postMessage';
        $bodyParam = [
            'body' => [
                'token' => $this->token,
                'channel' => $channel,
                'text' => $text
            ]
        ];

        $this->client->expects($this->once())
            ->method('post')
            ->with($url, $bodyParam)
            ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($response));

        $slack = new Slack($this->client, $this->token);
        $result = $slack->sendMessage($text, $channel);
        $arrayResponse = json_decode($result, true);
        $this->assertTrue($arrayResponse['ok']);
        $this->assertEquals($arrayResponse['channel'], $channel);
        $this->assertEquals($arrayResponse['message']['text'], $text);
    }   

    /**
     * Ensure list of users can be retrieved
     * Method: retrieveUsers 
     */
    public function testEnsureUserListCanBeRetrieved()
    {
        // provide test body
    }

    /**
     * Ensure Team Info Can Be Retrieved
     * Method: retrieveTeamInfo
     */
    public function testEnsureTeamInfoCanBeRetrieved()
    {
        // provide test body
    }

    /**
     * There is a ClientException that Guzzle can throw when things don't work correctly
     * this can be due to a 404, a resource being down or some other error on the client side
     * Write a couple tests that will ensure the exceptions are hit
     */
}
