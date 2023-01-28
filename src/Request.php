<?php
declare(strict_types=1);

namespace Trejjam\Ares;

use GuzzleHttp;
use Nette\Http\Url;
use SimpleXMLElement;

class Request
{
    private const URL = 'http://wwwinfo.mfcr.cz/cgi-bin/ares/darv_bas.cgi';

    public function __construct(
        public readonly GuzzleHttp\Client $httpClient,
        public readonly IMapper $mapper
    ) {
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

        $xml = simplexml_load_string($contents);
        if ($xml === false) {
            throw (new IcoNotFoundException($ico))->setResponse($response);
        }

        return $xml;
    }

    public function getResponse(string $ico) : Entity\Ares
    {
        return $this->mapper->map(
            $this->fetch($ico),
            $ico
        );
    }

    protected function createUrl(string $ico) : string
    {
        $url = new Url(self::URL);
        $url->setQueryParameter('ico', $ico);

        return $url->getAbsoluteUrl();
    }
}
