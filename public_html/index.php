<?php
/**
 * Created by PhpStorm.
 * User: v.sadovnikov
 * Date: 16.01.2020
 * Time: 14:23
 */
require dirname(__DIR__).'/vendor/autoload.php';
require dirname(__DIR__). '/config.php';
//
$query = [
    'response_type' => 'code',
    'client_id' => $appId,
    'device_id' => $deviceId,
    'device_name' => $deviceName,
    //'redirect_uri' => "https://{$hostDomain}",
    //'redirect_uri' => "https://oauth.yandex.ru/verification_code",
    //'redirect_uri' => "https://vk.com",
    'scope' => 'cloud_api:disk.app_folder cloud_api:disk.read cloud_api:disk.info',
    'display' => 'popup'
];
//echo $finalUrl;

//function getResponse($url, $params, $method = 'GET')
//{
//    $client = new \GuzzleHttp\Client();
//    $response = $client->request($method, $url, $params);
//
//    return (string)$response->getBody();
//}
//
//$resourceUrl = 'https://cloud-api.yandex.net/v1/disk';
$authUrl = 'https://oauth.yandex.ru/authorize';
//echo $authUrl . '/?' . http_build_query($query);

$controller = new \App\YandexDisk\Api\BaseApiController();
$diskInfo = $controller->getDiskInfo($token);

//html
echo '
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Disk info</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
              integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
                integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
                integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="app.js"></script>
    </head>
    <body>
    <div id="content">
    ';


if (!$diskInfo) {
    $authUrl = $controller->generateUrl('https://oauth.yandex.ru/authorize', $query);
    echo "<a target='_blank' class='btn btn-warning' href='{$authUrl}' role='button' onclick='renderForm()'>Авторизоваться на яндекс диске</a>";
} else {
    echo "
        <div class=\"alert alert-secondary\" role=\"alert\">
        <h1 class=\"h1\">Api response</h1>
        {$diskInfo}
        </div>
    ";
}

echo '</div></body>
</html>
';