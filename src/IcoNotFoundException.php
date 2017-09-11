<?php
declare(strict_types=1);

namespace Trejjam\Ares;

use Psr\Http;
use Throwable;

class IcoNotFoundException extends InvalidArgumentException
{
	/**
	 * @var string
	 */
	private $ico;
	/**
	 * @var Http\Message\ResponseInterface
	 */
	private $response;

	public function __construct(string $ico, string $message = '', int $code = 0, Throwable $previous = NULL)
	{
		parent::__construct($message, $code, $previous);

		$this->ico = $ico;
	}

	public function getIco() : string
	{
		return $this->ico;
	}

	public function setResponse(Http\Message\ResponseInterface $response) : self
	{
		$this->response = $response;

		return $this;
	}

	public function getResponse() :?Http\Message\ResponseInterface
	{
		return $this->response;
	}
}
