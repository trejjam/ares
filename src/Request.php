<?php
declare(strict_types=1);

namespace Trejjam\Ares;

use GuzzleHttp;
use Nette;
use Psr\Http;
use SimpleXMLElement;

class Request
{
	const URL = 'http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi';

	/**
	 * @var GuzzleHttp\Client
	 */
	private $httpClient;
	/**
	 * @var IMapper
	 */
	private $mapper;

	public function __construct(
		GuzzleHttp\Client $httpClient,
		IMapper $mapper
	) {
		$this->httpClient = $httpClient;
		$this->mapper = $mapper;
	}

	public function fetch(string $ico) : SimpleXMLElement
	{
		$response = $this->httpClient->get(
			$this->createUrl($ico)
		);

		if ($response->getStatusCode() !== 200) {
			throw (new IcoNotFoundException($ico))->setResponse($response);
		}

		$body = $response->getBody();

		$contents = $body->getContents();

		$xml = @simplexml_load_string($contents);

		if ($xml === FALSE) {
			throw (new IcoNotFoundException($ico))->setResponse($response);
		}

		return $xml;
	}

	public function getResponse(string $ico)
	{
		return $this->mapper->map(
			$this->fetch($ico),
			$ico
		);
	}

	protected function createUrl(string $ico)
	{
		$url = new Nette\Http\Url(static::URL);
		$url->setQueryParameter('ico', $ico);

		return $url->getAbsoluteUrl();
	}
}
