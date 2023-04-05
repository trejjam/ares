<?php
declare(strict_types=1);

namespace Trejjam\Ares;

use DateTimeImmutable;
use Exception;
use Nette;
use SimpleXMLElement;

final class Mapper implements IMapper
{
    public function map(SimpleXMLElement $xml, string $ico) : Entity\Ares
    {
        $namespace = $xml->getDocNamespaces();

        if ($namespace === false) {
            throw new RuntimeException('Unable to get namespace of the document');
        }

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

        return $this->mapToEntity($dataNodes->VBAS);
    }

    /**
     * @throws Exception
     */
    private function mapToEntity(SimpleXMLElement $VBAS) : Entity\Ares
    {
        $legalForm = new Entity\LegalForm(
            intval($VBAS->PF->KPF),
            strval($VBAS->PF->NPF)
        );

        $AA = $VBAS->AA;

        if (isset($AA->CA) && !isset($AA->CD) && !isset($AA->CO)) {
            $ca = explode('/', strval($AA->CA), 2);
            $AA->CD = $ca[0];
            $AA->CO = $ca[1] ?? '';
        }

        $address = new Entity\Address(
            intval($AA->IDA),
            intval($AA->KS),
            strval($AA->NS),
            strval($AA->N),
            strval($AA->NCO),
            strval($AA->NMC),
            strval($AA->NU),
            strval($AA->CD),
            strval($AA->CO),
            intval($AA->PSC)
        );

        $dic = null;
        if (isset($VBAS->DIC)) {
            $dic = strval($VBAS->DIC);
        }

        $dateEstablishment = new DateTimeImmutable(
            strval($VBAS->DV)
        );

        return new Entity\Ares(
            strval($VBAS->ICO),
            $dic,
            strval($VBAS->OF),
            $dateEstablishment,
            $legalForm,
            $address
        );
    }
}
