<?php
namespace Tutorial\Mocking\API;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ServerException;
use Exception;

/**
 * @author Matt Frost <mfrost.design@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @package Tutorial
 * @subpackage Mocking
 * @subpackage API
 */
class Slack
{
    /**
     * @const baseurl
     */
    const BASEURL = 'https://slack.com/api/';

    /**
     * @var GuzzleHttp\Client
     */
    private $client;

    /**
     * @var string
     */
    private $token;

    /**
     * Constructor
     *
     * @param GuzzleHttp\Client $client
     */
    public function __construct(Client $client, $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    /**
     * API call to retrieve the channels associated to an account
     *
     * @return string
     */
    public function retrieveChannels()
    {
        $url = self::BASEURL . 'channels.list';

        try {
            $response = $this->client->post($url, [
                'body' => [
                    'token' => $this->token
                ]
            ]);

        } catch (ClientException $e) {

            // rethrow it for test 
            throw $e;
    
        } catch (BadResponseException $e) {

            throw $e;

        } catch(ServerException $e) {

            throw $e;

        } catch(Exception $e) {

            throw $e;

        }    

        return $response->getBody();
    }

    /**
     * Method to use Slack API to send message to specified channel
     *
     * @param string $message
     * @param string $channelId
     * @return string
     */
    public function sendMessage($message, $channelId = 'C049WBRCC')
    {
        $url = self::BASEURL . 'chat.postMessage';
        try {

            $response = $this->client->post($url, [
                'body' => [
                    'token' => $this->token,
                    'channel' => $channelId,
                    'text' => $message
                ]
            ]);

        } catch(ClientException $e) {

            //handle exception
            throw $e;

        } catch (BadResponseException $e) {

            throw $e;

        } catch(ServerException $e) {

            throw $e;

        } catch(Exception $e) {

            throw $e;

        }    

        return $response->getBody();
    }

    /**
     * Method to retrieve all the users from Slack API
     *
     * @return string
     */
    public function retrieveUsers()
    {
        $url = self::BASEURL . 'users.list?token=' . $this->token;
        try {

            $response = $this->client->get($url);

        } catch(ClientException $e) {

            //handle exception
            throw $e;

        } catch (BadResponseException $e) {

            throw $e;

        } catch(ServerException $e) {

            throw $e;

        } catch(Exception $e) {

            throw $e;

        }

        return $response->getBody();
    }

    /**
     * Method to retrieve the Team Info from Slack
     *
     * @return string
     */
    public function retrieveTeamInfo()
    {
        $url = self::BASEURL . 'team.info?token=' . $this->token;
        try {

            $response = $this->client->get($url);

        } catch(ClientException $e) {

            //handle exception
            throw $e;

        } catch (BadResponseException $e) {

            throw $e;

        } catch(ServerException $e) {

            throw $e;

        } catch(Exception $e) {

            throw $e;

        }

        return $response->getBody();
    }
}
