<?php
namespace App\Http\Services;

use GuzzleHttp\Client;

class ShortUrlService
{
    protected $client;
    public function __construct()
    {
        $this->client = new Client();
    }
    public function makeShorturl($url)
    {
        $accesstoken = env('URL_ACCESS_TOKEN');
        $data = [
            'url' => $url
        ];
        $response = $this->client->request(
            'POST',
            "https://api.pics.ee/v1/links/?access_token=$accesstoken",
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($data)
            ]
        );
        $contents = $response->getBody()->getContents();
        $contents = json_decode($contents);
        return $contents->data->picseeUrl;
    }
}