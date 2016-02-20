<?php

require __DIR__ . '/../vendor/autoload.php';

$credentials = include(__DIR__ . '/./config.php');
echo (new App\Github)->user($credentials);

//echo (new GuzzleHttp\Client([
//    'base_uri' => 'https://api.github.com'
//]))->get('users/' . $credentials['username'])->getBody();
