<?php

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@DoctrineAnnotation' => true,
        '@PHP80Migration' => true,
        '@PHP80Migration:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,

        // From https://github.com/symfony/demo/blob/main/.php-cs-fixer.dist.php
        'linebreak_after_opening_tag' => true,
        // 'mb_str_functions' => true,
        'no_php4_constructor' => true,
        'no_unreachable_default_argument_value' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'php_unit_strict' => true,
        'phpdoc_order' => true,
        'strict_comparison' => true,
        'strict_param' => true,
    ])
    ->setFinder(
        (new PhpCsFixer\Finder())
            ->in(['src', 'tests'])
    )
;
