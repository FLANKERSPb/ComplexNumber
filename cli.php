<?php

use Complex\ComplexNumber;

$tests_count = (int)($argv[1] ?? 10);

require __DIR__ . '/include.php';

$output = [];

$max_strlen = 0;

// output index
$i = 0;

foreach ($staicMethods as $method) {
    $output[$i] = "\e[96mComplexNumber::$method()";

    $i++;

    $j = $max_index;

    foreach ($numbers as $number) {
        $current_numbers = [];

        for ($max_arguments = min(2, $j); $max_arguments > 0; $max_arguments--) {
            $current_numbers[] = $numbers[rand(0, $max_index)];
        }

        $current_numbers[] = $number;

        $str = "  \e[97m$method " . implode(
                "\e[97m, ",
                array_map(
                    function ($v) {
                        return e($v);
                    },
                    $current_numbers
                )
            );

        $max_strlen = max($max_strlen, strlen(preg_replace('/\e\[\d\dm/', '', $str)));

        $output[$i][] = $str;

        try {
            $output[$i][] = "\e[97mresult: " . e(ComplexNumber::$method(...$current_numbers));
        } catch (Exception $e) {
            $output[$i][] = "\e[91mError: {$e->getMessage()}";
        }

        $i++;
        $j--;
    }
}

$max_strlen += 2;

echo
    implode(
        PHP_EOL,
        array_map(
            function ($v) use ($max_strlen) {
                if (is_array($v)) {
                    $strlen = strlen(preg_replace('/\e\[\d\dm/', '', $v[0]));

                    return $v[0] . str_repeat(' ', ($max_strlen - $strlen)) . $v[1];
                }

                return $v;
            },
            $output
        )
    ) .
    PHP_EOL;

//-------------------------

$output = [];

$max_strlen = 0;

// output index
$i = 0;

foreach ($methods as $method) {
    $output[$i] = "\e[96m\$complex->$method()";

    $i++;

    foreach ($numbers as $number) {
        $number2 = clone $number;
        $number1 = clone $numbers[rand(0, $max_index)];

        $str = '  ' . e($number1) . " \e[97m$method " . e($number2);

        $max_strlen = max($max_strlen, strlen(preg_replace('/\e\[\d\dm/', '', $str)));

        $output[$i][] = $str;

        try {
            $output[$i][] = "\e[97mresult: " . e($number1->$method($number2));
        } catch (Exception $e) {
            $output[$i][] = "\e[91mError: {$e->getMessage()}";
        }

        $i++;
    }
}

$max_strlen += 2;

echo
    implode(
        PHP_EOL,
        array_map(
            function ($v) use ($max_strlen) {
                if (is_array($v)) {
                    $strlen = strlen(preg_replace('/\e\[\d\dm/', '', $v[0]));

                    return $v[0] . str_repeat(' ', ($max_strlen - $strlen)) . $v[1];
                }

                return $v;
            },
            $output
        )
    ) .
    PHP_EOL;
