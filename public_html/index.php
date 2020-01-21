<?php
/**
 * Created by PhpStorm.
 * User: v.sadovnikov
 * Date: 16.01.2020
 * Time: 14:23
 */
require dirname(__DIR__).'/vendor/autoload.php';
$controllerFront = new \App\YandexDisk\ControllerFront();
$controllerFront->index($_GET, $_POST, $_COOKIE);