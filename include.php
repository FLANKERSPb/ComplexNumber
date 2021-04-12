<?php

use Complex\ComplexNumber;

require __DIR__ . '/Complex/ComplexNumber.php';

define('IS_CLI', php_sapi_name() == 'cli');


function e(ComplexNumber $number): string
{
    $sign = $number->Im > 0 ? '+' : '-';

    $Re = number_format($number->Re, 2, '.', '');
    $Im = number_format(abs($number->Im), 2, '.', '');

    if (IS_CLI) {
        return $number->isReal() ? "\e[93m{$Re}\e[96m" : "\e[93m{$Re}{$sign}{$Im}\e[96mi";
    } else {
        if ($number->isReal()) {
            return "<span class='complex'>$Re</span>";
        } else {
            return "<span class='complex'>$Re$sign$Im<span class='i'>i</span></span>";
        }
    }
}

function rand_float($min = -100, $max = 100): float
{
    return (rand($min * 100, $max * 100) / 100);
}

function array_fill_rand_complex(&$array, $count = 100): void
{
    for ($i = 0; $i < $count; $i++) {
        $array[] = new ComplexNumber(rand_float(), rand_float());
    }
}

$zero = new ComplexNumber(0, 0);
$real = new ComplexNumber(rand_float(), 0);
$comp = new ComplexNumber(0, rand_float());

$numbers = [
    $zero,
    $real,
    $comp
];

$tests_count = max(sizeof($numbers), $tests_count);

array_fill_rand_complex($numbers, $tests_count - sizeof($numbers));

$max_index = $tests_count - 1;

$staicMethods = [
    'sum',
    'difference',
    'product',
    'quotient',
];

$methods = [
    'add',
    'subtract',
    'multiply',
    'divide',
];
