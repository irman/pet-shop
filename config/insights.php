<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use NunoMaduro\PhpInsights\Domain\Insights\SyntaxCheck;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterCastSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterNotSniff;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use SlevomatCodingStandard\Sniffs\Classes\ClassConstantVisibilitySniff;
use SlevomatCodingStandard\Sniffs\Classes\ForbiddenPublicPropertySniff;
use SlevomatCodingStandard\Sniffs\Commenting\DocCommentSpacingSniff;
use SlevomatCodingStandard\Sniffs\Commenting\UselessFunctionDocCommentSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowEmptySniff;
use SlevomatCodingStandard\Sniffs\Namespaces\AlphabeticallySortedUsesSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Preset
    |--------------------------------------------------------------------------
    |
    | This option controls the default preset that will be used by PHP Insights
    | to make your code reliable, simple, and clean. However, you can always
    | adjust the `Metrics` and `Insights` below in this configuration file.
    |
    | Supported: "default", "laravel", "symfony", "magento2", "drupal"
    |
    */
    'preset' => 'laravel',

    'ide' => 'phpstorm',

    'exclude' => [
        'app/Providers'
    ],

    'add' => [],

    'remove' => [
        // Code
        DeclareStrictTypesSniff::class,          // Declare strict types
        ForbiddenPublicPropertySniff::class,       // Forbidden public property
        VisibilityRequiredFixer::class,                   // Visibility required
        ClassConstantVisibilitySniff::class,       // Class constant visibility
        DisallowEmptySniff::class,       // Disallow empty
        NoEmptyCommentFixer::class,                             // No empty comment
        UselessFunctionDocCommentSniff::class,  // Useless function doc comment

        // Architecture
        ForbiddenNormalClasses::class,            //Normal classes are forbidden

        // Style
        SpaceAfterCastSniff::class,  // Space after cast
        SpaceAfterNotSniff::class,   // Space after not
        AlphabeticallySortedUsesSniff::class,   // Alphabetically sorted uses
        DocCommentSpacingSniff::class,          // Doc comment spacing
        OrderedClassElementsFixer::class,                 // Ordered class elements
        SingleQuoteFixer::class,                         // Single quote

        SyntaxCheck::class,
    ],

    'config' => [
        CyclomaticComplexityIsHigh::class => [
            'maxComplexity' => 8,
        ],
        LineLengthSniff::class => [
            'lineLimit' => 120,
            'absoluteLineLimit' => 120,
            'ignoreComments' => false,
        ],
        OrderedImportsFixer::class => [
            'imports_order' => ['class', 'const', 'function'],
            'sort_algorithm' => 'length',
        ]
    ],

    'requirements' => [
        'min-quality' => 75,
        'min-complexity' => 75,
        'min-architecture' => 75,
        'min-style' => 75,
        'disable-security-check' => false,
    ],

];
