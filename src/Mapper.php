<?php
declare(strict_types=1);

namespace Trejjam\Ares;

use Nette;

class Mapper implements IMapper
{
	public function map(\SimpleXMLElement $xml, string $ico)
	{
		$namespace = $xml->getDocNamespaces();

		$rootNode = $xml->children(
			$namespace['are']
		);

		if ($rootNode->getName() !== 'Odpoved') {
			throw (new IcoNotFoundException($ico));
		}

		$dataNodes = $rootNode->children(
			$namespace['D']
		);

		if (isset($dataNodes->E)) {
			$errorNode = $dataNodes->E;

			throw (new IcoNotFoundException(
				$ico,
				Nette\Utils\Strings::trim(strval($errorNode->ET)),
				intval($errorNode->EK)
			));
		}

		//TODO process $dataNodes;
	}
}
