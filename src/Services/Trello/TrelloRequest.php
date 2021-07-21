<?php

namespace AdrHumphreys\Workflow\Services\Trello;

use GuzzleHttp\Psr7\Request;

class TrelloRequest extends Request
{
    public static function get(string $url, ?array $queryParams = null): ?array
    {
        $request = new TrelloRequest('GET', $url);
        $response = Client::create()->send($request, $queryParams);
        $contents = $response->getBody()->getContents();

        return json_decode($contents, true);
    }

    public static function post(string $url, ?array $queryParams = null): ?array
    {
        $request = new TrelloRequest('POST', $url);
        $response = Client::create()->send($request, $queryParams);
        $contents = $response->getBody()->getContents();

        return json_decode($contents, true);
    }

    public static function put(string $url, ?array $queryParams = null): void
    {
        $request = new TrelloRequest('PUT', $url);
        Client::create()->send($request, $queryParams);
    }
}
