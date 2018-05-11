<?php

namespace HtmlDriven\CorsProxy;

use DateTime;
use Dibi\Connection as DibiConnection;
use Dibi\Exception as DibiException;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Exception\RequestException;
use Guzzle\Http\Message\Response;

/**
 * Handles actual request sending.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class RequestHandler
{
    /** @var Config */
    private $config;

    /** @var ClientInterface */
    private $client;

    /** @var DibiConnection */
    private $dibiConnection;

    public function __construct(
        Config $config,
        ClientInterface $client,
        DibiConnection $dibiConnection
    ) {
        $this->client = $client;
        $this->dibiConnection = $dibiConnection;
    }

    /**
     * Sends the request to given URL and returns JSON response.
     *
     * @param string
     * @param string
     * @return void
     */
    public function handleRequest($method, $url)
    {
        $request = $this->client->createRequest($method, $url);

        $json = [
            'success' => true,
            'error' => null,
            'body' => null,
        ];

        $this->enableCrossDomainRequests();

        $response = null;
        try {
            $response = $request->send(true);
        } catch (RequestException $e) {
            $json['success'] = false;
            $json['error'] = sprintf("Unable to handle request: CURL failed with message '%s'.", $e->getMessage());

            http_response_code(400);
        }

        if (isset($response)) {
            $json['body'] = $response->getBody(true);
        } else {
            $json['body'] = null;
        }

        if ($this->config->isRequestLogEnabled()) {
            try {
                $this->dibiConnection
                    ->insert('request_log', [
                        'method' => $request->getMethod(),
                        'scheme' => $request->getScheme(),
                        'host' => $request->getHost(),
                        'path' => $request->getPath(),
                        'query' => (string) $request->getQuery(),
                        'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ?
                            $_SERVER['HTTP_USER_AGENT'] : null,
                        'request_headers' => null, // TODO: not yet supported
                        'request_body' => null, // TODO: not yet supported
                        'response_headers' => isset($response) ?
                            json_encode($this->getHeadersFromResponse($response)) : null,
                        'response_body' => $json['body'],
                        'date_created' => (new DateTime())->format('Y-m-d H:i:s'),
                    ])
                    ->execute();
            } catch (DibiException $e) {
                // TODO: use custom error logging
                error_log($e->getMessage());
            }
        }

        header('Content-Type: application/json');
        echo json_encode($json);
    }

    /**
     * Enables cross-domain requests.
     *
     * @return void
     */
    private function enableCrossDomainRequests()
    {
        header_remove('Access-Control-Allow-Origin');
        header('Access-Control-Allow-Origin: *');
    }

    /**
     * @param Response
     * @return array
     */
    private function getHeadersFromResponse(Response $response)
    {
        $headers = [];
        foreach ($response->getHeaders() as $header => $value) {
            $headers[$header] = (string) $value;
        }
        return $headers;
    }
}
