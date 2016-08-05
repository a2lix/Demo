<?php

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'ordered_imports' => true,
        'phpdoc_order' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'short_array_syntax' => true,
    ])
    ->finder(
        PhpCsFixer\Finder::create()
        ->exclude(['app','bin','var','vendor','web'])
        ->in(__DIR__)
    )
;
