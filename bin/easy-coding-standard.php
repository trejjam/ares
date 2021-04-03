<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\PSR2\Sniffs\ControlStructures\ControlStructureSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ForEachLoopDeclarationSniff;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesInsideParenthesisFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;

$rootDir = __DIR__ . '/../';

return static function (ContainerConfigurator $containerConfigurator) use ($rootDir) : void {
    $containerConfigurator->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/common/array.php');

    $containerConfigurator->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/common/control-structures.php');

    $containerConfigurator->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/common/docblock.php');

    $containerConfigurator->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/common/namespaces.php');

    $containerConfigurator->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/common/strict.php');

    $containerConfigurator->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/clean-code.php');

    $containerConfigurator->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/psr12.php');

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::INDENTATION, 'spaces');

    $parameters->set(Option::SKIP, [
        BlankLineAfterOpeningTagFixer::class     => null,
        ArrayOpenerAndCloserNewlineFixer::class  => null,
        NewWithBracesFixer::class                => null,
        ControlStructureSpacingSniff::class      => null,
        ForEachLoopDeclarationSniff::class       => null,
        BracesFixer::class                       => null,
        OrderedClassElementsFixer::class         => null,
        BinaryOperatorSpacesFixer::class         => null,
        NoSpacesInsideParenthesisFixer::class    => null,
    ]);

    $services = $containerConfigurator->services();

    $services->set(ReturnTypeDeclarationFixer::class)
             ->call('configure', [['space_before' => 'one']]);
};
