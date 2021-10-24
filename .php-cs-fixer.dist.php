<?php

$excludes = [
    'vendor',
];

$rules = include '.php-cs-fixer-rules.php';

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude($excludes);

return (new PhpCsFixer\Config())
    ->setRules($rules)
    ->setFinder($finder);
