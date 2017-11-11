<?php

namespace HtmlDriven\CorsProxyTests\Mock;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\RequestInterface;
use HtmlDriven\CorsProxyTests\Mock\FakeRequest;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Fake client which always returns fake request.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class FakeClient implements ClientInterface
{
    /** @var FakeRequest */
    private $fakeRequest;

    /**
     * @param FakeRequest
     */
    public function __construct(FakeRequest $fakeRequest)
    {
        $this->fakeRequest = $fakeRequest;
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
    }

    public function createRequest(
        $method = RequestInterface::GET,
        $uri = null,
        $headers = null,
        $body = null,
        array $options = []
    ) {
        return $this->fakeRequest;
    }

    public function delete($uri = null, $headers = null, $body = null, array $options = [])
    {
    }

    public function dispatch($eventName, array $context = [])
    {
    }

    public function get($uri = null, $headers = null, $options = [])
    {
        return $this->fakeRequest;
    }

    public function getBaseUrl($expand = true)
    {
    }

    public function getConfig($key = false)
    {
    }

    public function getEventDispatcher()
    {
    }

    public function head($uri = null, $headers = null, array $options = [])
    {
    }

    public function options($uri = null, array $options = [])
    {
    }

    public function patch($uri = null, $headers = null, $body = null, array $options = [])
    {
    }

    public function post($uri = null, $headers = null, $postBody = null, array $options = [])
    {
    }

    public function put($uri = null, $headers = null, $body = null, array $options = [])
    {
    }

    public function send($requests)
    {
    }

    public function setBaseUrl($url)
    {
    }

    public function setConfig($config)
    {
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
    }

    public function setSslVerification($certificateAuthority = true, $verifyPeer = true, $verifyHost = 2)
    {
    }

    public function setUserAgent($userAgent, $includeDefault = false)
    {
    }

    public static function getAllEvents()
    {
    }
}
