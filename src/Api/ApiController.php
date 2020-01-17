<?php
/**
 * Created by PhpStorm.
 * User: v.sadovnikov
 * Date: 16.01.2020
 * Time: 14:26
 */

namespace App\YandexDisk\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


class ApiController
{
    
    private $client;
    private $params;
    
    public function __construct()
    {
        $this->client = new Client();
        $this->params = [
            'client_id' => 'f5ecd9498fc2476eb09ca9ee965804b4',
            'client_secret' => '69b89a5c40d848f0bdc7c14c9bf55734',
            'device_id' => uniqid('application', true),
            'device_name' => 'application',
            'scope' => 'cloud_api:disk.app_folder cloud_api:disk.read cloud_api:disk.info',
        ];
    }
    
    /**
     * @param $url
     * @param $query
     *
     * @return string
     */
    public function generateUrl($url, $query)
    {
         return $url .  '/?' . http_build_query($query);
    }
    
    
    /**
     * @param $code
     *
     * @return string|null
     */
    public function getDiskInfoByCode($code)
    {
        if (!$code) {
            return null;
        }
        
        try{
            $response = $this->client->request('POST', 'https://oauth.yandex.ru/token', ['form_params' => [
                'grant_type' => 'device_code',
                'code' => $code,
                'client_id' => $this->params['client_id'],
                'client_secret' => $this->params['client_secret'],
            ]]);
    
            $tokenData = json_decode((string)$response->getBody(), true);
            
            $response = $this->client->request('GET', 'https://cloud-api.yandex.net/v1/disk', ['headers' => ['Authorization' => $tokenData['access_token']]]);
        } catch (GuzzleException $exception) {
            return null;
        }
        
        return (string)$response->getBody();
    }
    
    /**
     * @return string|null
     */
    public function getCodeData()
    {
        try{
        
            $response = $this->client->request('POST', 'https://oauth.yandex.ru/device/code', ['form_params' => $this->params]);
        } catch (GuzzleException $exception) {
        return null;
        }
    
        return (string)$response->getBody();
    }
}