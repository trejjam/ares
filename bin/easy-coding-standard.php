<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\PSR2\Sniffs\ControlStructures\ControlStructureSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\ControlStructures\ForEachLoopDeclarationSniff;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureContinuationPositionFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesInsideParenthesisFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

$rootDir = __DIR__ . '/../';

return static function (ECSConfig $ecsConfig) use ($rootDir) : void {
    $ecsConfig->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/common/array.php');

    $ecsConfig->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/common/control-structures.php');

    $ecsConfig->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/common/docblock.php');

    $ecsConfig->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/common/namespaces.php');

    $ecsConfig->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/common/strict.php');

    $ecsConfig->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/clean-code.php');

    $ecsConfig->import($rootDir . 'vendor/symplify/easy-coding-standard/config/set/psr12.php');

    $ecsConfig->indentation('spaces');

    $ecsConfig->skip([
        BlankLineAfterOpeningTagFixer::class => null,
        ArrayOpenerAndCloserNewlineFixer::class => null,
        NewWithBracesFixer::class => null,
        ControlStructureSpacingSniff::class => null,
        ForEachLoopDeclarationSniff::class => null,
        BracesFixer::class => null,
        OrderedClassElementsFixer::class => null,
        BinaryOperatorSpacesFixer::class => null,
        NoSpacesInsideParenthesisFixer::class => null,
    ]);

    $ecsConfig->ruleWithConfiguration(ReturnTypeDeclarationFixer::class, [
        'space_before' => 'one',
    ]);
    $ecsConfig->ruleWithConfiguration(ControlStructureContinuationPositionFixer::class, [
        'position' => ControlStructureContinuationPositionFixer::NEXT_LINE,
    ]);
};
