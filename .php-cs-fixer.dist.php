<?php

$finder = (new PhpCsFixer\Finder())
    ->in(['src'])
    ->notPath('bootstrap.php')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->registerCustomFixers(new PhpCsFixerCustomFixers\Fixers())
    ->setRules([
        '@DoctrineAnnotation' => true,
        '@PHP83Migration' => true,
        // '@PHPUnit100Migration:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,

        // From https://github.com/symfony/demo/blob/main/.php-cs-fixer.dist.php
        'linebreak_after_opening_tag' => true,
        // 'mb_str_functions' => true,
        'no_php4_constructor' => true,
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'php_unit_strict' => false,
        'php_unit_internal_class' => false,
        'php_unit_test_class_requires_covers' => false,
        'phpdoc_order' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'trailing_comma_in_multiline' => ['after_heredoc' => true, 'elements' => ['arrays', 'parameters']],
        'statement_indentation' => true,
        'method_chaining_indentation' => true,
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline', 'attribute_placement' => 'ignore'],

         PhpCsFixerCustomFixers\Fixer\ConstructorEmptyBracesFixer::name() => true,
         PhpCsFixerCustomFixers\Fixer\MultilineCommentOpeningClosingAloneFixer::name() => true,
         PhpCsFixerCustomFixers\Fixer\MultilinePromotedPropertiesFixer::name() => true,
         PhpCsFixerCustomFixers\Fixer\NoDuplicatedImportsFixer::name() => true,
         PhpCsFixerCustomFixers\Fixer\NoImportFromGlobalNamespaceFixer::name() => true,
         PhpCsFixerCustomFixers\Fixer\PhpdocSingleLineVarFixer::name() => true,
    ])
    ->setFinder($finder)
;
