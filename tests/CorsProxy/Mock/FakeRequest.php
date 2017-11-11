<?php

namespace HtmlDrivenTests\CorsProxy\Mock;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Fake request which always returns defined response.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class FakeRequest implements RequestInterface
{
    /** @var Response|callable */
    private $response;

    /**
     * @param Response|callable
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function __toString()
    {
    }

    public function addCookie($name, $value)
    {
    }

    public function addHeader($header, $value)
    {
    }

    public function addHeaders(array $headers)
    {
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
    }

    public function dispatch($eventName, array $context = array())
    {
    }

    public function getClient()
    {
    }

    public function getCookie($name)
    {
    }

    public function getCookies()
    {
    }

    public function getCurlOptions()
    {
    }

    public function getEventDispatcher()
    {
    }

    public function getHeader($header)
    {
    }

    public function getHeaderLines()
    {
    }

    public function getHeaders()
    {
    }

    public function getHost()
    {
    }

    public function getMethod()
    {
    }

    public function getParams()
    {
    }

    public function getPassword()
    {
    }

    public function getPath()
    {
    }

    public function getPort()
    {
    }

    public function getProtocolVersion()
    {
    }

    public function getQuery()
    {
    }

    public function getRawHeaders()
    {
    }

    public function getResource()
    {
    }

    public function getResponse()
    {
    }

    public function getResponseBody()
    {
    }

    public function getScheme()
    {
    }

    public function getState()
    {
    }

    public function getUrl($asObject = false)
    {
    }

    public function getUsername()
    {
    }

    public function hasHeader($header)
    {
    }

    public function removeCookie($name)
    {
    }

    public function removeHeader($header)
    {
    }

    public function send()
    {
        if (is_callable($this->response)) {
            return call_user_func($this->response);
        }
        return $this->response;
    }

    public function setAuth($user, $password = '', $scheme = 'Basic')
    {
    }

    public function setClient(ClientInterface $client)
    {
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
    }

    public function setHeader($header, $value)
    {
    }

    public function setHeaders(array $headers)
    {
    }

    public function setHost($host)
    {
    }

    public function setPath($path)
    {
    }

    public function setPort($port)
    {
    }

    public function setProtocolVersion($protocol)
    {
    }

    public function setResponse(Response $response, $queued = false)
    {
    }

    public function setResponseBody($body)
    {
    }

    public function setScheme($scheme)
    {
    }

    public function setState($state, array $context = array())
    {
    }

    public function setUrl($url)
    {
    }

    public function startResponse(Response $response)
    {
    }

    public static function getAllEvents()
    {
    }
}
