<?php

namespace HtmlDrivenTests\CorsProxy\Mock;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\RequestInterface;
use HtmlDrivenTests\CorsProxy\Mock\FakeRequest;
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

	public function createRequest($method = RequestInterface::GET, $uri = NULL, $headers = NULL, $body = NULL, array $options = [])
	{
		
	}

	public function delete($uri = NULL, $headers = NULL, $body = NULL, array $options = [])
	{

	}

	public function dispatch($eventName, array $context = [])
	{

	}

	public function get($uri = NULL, $headers = NULL, $options = [])
	{
		return $this->fakeRequest;
	}

	public function getBaseUrl($expand = TRUE)
	{

	}

	public function getConfig($key = FALSE)
	{

	}

	public function getEventDispatcher()
	{

	}

	public function head($uri = NULL, $headers = NULL, array $options = [])
	{

	}

	public function options($uri = NULL, array $options = [])
	{

	}

	public function patch($uri = NULL, $headers = NULL, $body = NULL, array $options = [])
	{

	}

	public function post($uri = NULL, $headers = NULL, $postBody = NULL, array $options = [])
	{

	}

	public function put($uri = NULL, $headers = NULL, $body = NULL, array $options = [])
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

	public function setSslVerification($certificateAuthority = TRUE, $verifyPeer = TRUE, $verifyHost = 2)
	{

	}

	public function setUserAgent($userAgent, $includeDefault = FALSE)
	{

	}

	public static function getAllEvents()
	{

	}
}
