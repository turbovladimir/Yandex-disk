<?php
/**
 * Created by PhpStorm.
 * User: v.sadovnikov
 * Date: 17.01.2020
 * Time: 11:09
 */

namespace App\YandexDisk;


use App\YandexDisk\Api\ApiController;

class ControllerFront
{
    private $template;
    private $api;
    
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__).'/templates');
        $twig = new \Twig\Environment($loader);
        $this->template = $twig->load('index.html.twig');
        $this->api = new ApiController();
    }
    
    
    
    public function index($get, $post, $cookie)
    {
        $parameters = [];
    
        if (!empty($get['reset_code'])) {
            $parameters['codeData'] = $this->generateNewCodeData();
        }
        
        if (!empty($get['get_disc_info'])) {
            if (!empty($cookie['device_code'])) {
                $diskInfo = $this->api->getDiskInfoByCode($cookie['device_code']);
        
                if ($diskInfo) {
                    $parameters['diskInfo'] = $diskInfo;
                } else {
                    $parameters['codeData'] = [
                        'user_code' => $cookie['user_code'],
                        'verification_url' => $cookie['verification_url'],
                    ];
                }
            } else {
                $parameters['codeData'] = $this->generateNewCodeData();
            }
        }
        
        echo $this->template->render($parameters);
    }
    
    /**
     * @return mixed|null
     */
    private function generateNewCodeData()
    {
        $codeData = $this->api->getCodeData();
    
        if (!$codeData) {
            return null;
        }
        
        $codeData = json_decode($codeData, true);
        $this->setCookies($codeData, time() + 300);
    
        return $codeData;
    }
    
    /**
     * @param        $cookieParams
     * @param        $expire
     * @param string $path
     */
    private function setCookies($cookieParams, $expire, $path = '/')
    {
        foreach ($cookieParams as $paramName => $value)
        {
            setcookie($paramName, $value, $expire, $path);
        }
    }
}