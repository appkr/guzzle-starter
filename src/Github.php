<?php

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Github
{
    protected $debug = true;

    protected $client;

    public function __construct($base = null)
    {
        if (! $this->client) {
            $logger = new Logger('mylogger');
            $logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/log.txt'));

            $formatter = new MessageFormatter(MessageFormatter::DEBUG);

            $handler = HandlerStack::create()->push(
                Middleware::log($logger, $formatter)
            );

            $this->client = new Client([
                'base_uri' => $base ?: 'https://api.github.com',
                'handler'  => $handler
            ]);
        }
    }

    public function user($credentials)
    {
        try {
            $request = new Request('GET', 'users/' . $credentials['username'], [
                'debug' => $this->debug,
                'verify' => 'false',
                'headers' => [
                    'Accept' => 'application/vnd.github.v3+json',
                    'User-Agent' => 'Guzzle 6.2'
                ],
                'auth' => [
                    $credentials['username'],
                    $credentials['password']
                ]
            ]);

            $response = $this->client->send($request);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return $response->getBody();
    }
}