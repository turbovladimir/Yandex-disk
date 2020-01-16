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


class BaseApiController
{
    
    
    public function generateUrl($url, $query)
    {
         return $url .  '/?' . http_build_query($query);
    }
    
    
    /**
     * @param $token
     *
     * @return string|null
     */
    public function getDiskInfo($token)
    {
        try{
            $client = new Client();
            $response = $client->request('GET', 'https://cloud-api.yandex.net/v1/disk', ['headers' => ['Authorization' => $token]]);
        } catch (GuzzleException $exception) {
            return null;
        }
        
        return (string)$response->getBody();
    }
}