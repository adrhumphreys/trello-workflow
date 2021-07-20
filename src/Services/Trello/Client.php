<?php

namespace AdrHumphreys\Workflow\Services\Trello;

use AdrHumphreys\Workflow\Workflow;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use SilverStripe\Core\Injector\Injectable;
use Throwable;

/**
 * Why do we have a connector between us and Guzzle?
 * - It's nice to have an easy send() method available.
 * - This allows us to easily mock API responses in tests.
 */
class Client
{
    public const API_TIMEOUT = 60;

    use Injectable;

    protected ?GuzzleClient $client;

    public function __construct(?GuzzleClient $client = null)
    {
        if ($client === null) {
            $client = new GuzzleClient([
                'base_uri' => 'https://api.trello.com/',
            ]);
        }

        $this->client = $client;
    }

    public function getClient(): GuzzleClient
    {
        return $this->client;
    }

    public function send(Request $request, ?array $queryParams = null): ResponseInterface
    {
        try {
            $workflow = Workflow::get()->find('Service', Trello::class);

            if (!$workflow) {
                throw new \InvalidArgumentException('We need a workflow with an associated trello service');
            }

            $response = $this->getClient()->send($request, [
                RequestOptions::TIMEOUT => self::API_TIMEOUT,
                RequestOptions::QUERY => array_merge_recursive($queryParams ?? [], [
                    'key' => $workflow->TrelloKey,
                    'token' => $workflow->TrelloToken,
                ])
            ]);
        } catch (Throwable $e) {
            if ($e instanceof RequestException
                && $e->hasResponse()
            ) {
                return $e->getResponse();
            }

            $message = strlen($e->getMessage()) > 0
                ? $e->getMessage()
                : 'Unknown error during API request';

            $body = [
                'message' => $message,
            ];

            $response = new Response(500, [], json_encode($body));
        }

        return $response;
    }
}
