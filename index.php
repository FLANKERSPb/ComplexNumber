<?php

use Complex\ComplexNumber;

$tests_count = (int)($_POST['tests_count'] ?? 10);

require __DIR__ . '/include.php';

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,width=device-width">
    <title>Test complex numbers</title>
    <style>
        html {
            background-color: #000;
            color: #FFF;
            font-weight: bold;
            font-family: monospace;
        }

        body {
            padding: 20px 0;
            margin: 0 auto;
            max-width: 1024px;
        }

        h1, h2, h3, h4, h5, h6 {
            font-size: inherit;
            line-height: inherit;
            color: white;
        }

        .info {
            color: cyan;
        }

        .error {
            color: red;
        }

        .complex {
            color: orange;
        }

        .complex .i {
            color: cyan;
            font-style: italic;
        }
    </style>
</head>
<body>
<form method="post">
	<label for=tests_count">Count tests</label>
	<select id="tests_count" name="tests_count">
		<?php
		foreach ([5, 10, 20, 50, 100] as $c) {
			echo $tests_count == $c ? "<option selected>$c</option>" : "<option>$c</option>";
        }
        ?>
	</select>
	<input type="submit" value="Run">
</form>
<table>
    <?php
    foreach ($staicMethods as $method) {
        echo '<tr><td><h3 class="info">ComplexNumber::' . $method . '()</h3></td></tr>';

        $i = $max_index;

        foreach ($numbers as $key => $number) {
            $current_numbers = [];

            for ($j = min(2, $i); $j > 0; $j--) {
                $current_numbers[] = $numbers[rand(0, $max_index)];
            }

            $current_numbers[] = $number;

            $str = $method . ' ' . implode(
                    ', ',
                    array_map(
                        function ($v) {
                            return e($v);
                        },
                        $current_numbers
                    )
                );

            try {
                $res = 'result: ' . e(ComplexNumber::$method(...$current_numbers));
            } catch (Exception $e) {
                $res = '<span class="error">Error: ' . $e->getMessage() . '</span>';
            }

            echo "<tr><td>$str</td><td>$res</td></tr>";

            $i--;
        }
    }
    ?>
</table>
<table>
    <?php
    foreach ($methods as $method) {
        echo '<tr><td><h3 class="info">$complex->' . $method . '()</h3></td></tr>';

        foreach ($numbers as $number) {
            $number2 = clone $number;
            $number1 = clone $numbers[rand(0, $max_index)];

            $str = e($number1) . ' ' . $method . ' ' . e($number2);

            try {
                $res = 'result: ' . e($number1->$method($number2));
            } catch (Exception $e) {
                $res = '<span class="error">Error: ' . $e->getMessage() . '</span>';
            }

            echo "<tr><td>$str</td><td>$res</td></tr>";
        }
    }
    ?>
</table>
</body>
</html>
