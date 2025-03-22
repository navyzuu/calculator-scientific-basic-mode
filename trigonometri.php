<?php
    $specialAngles = [
        0 => ['sin' => '0', 'cos' => '1', 'tan' => '0', 'csc' => 'undefined', 'sec' => '1', 'cot' => 'undefined'],
        30 => ['sin' => '1/2', 'cos' => '√3/2', 'tan' => '1/√3', 'csc' => '2', 'sec' => '2√3/3', 'cot' => '√3'],
        45 => ['sin' => '1/√2', 'cos' => '1/√2', 'tan' => '1', 'csc' => '√2', 'sec' => '√2', 'cot' => '1'],
        60 => ['sin' => '√3/2', 'cos' => '1/2', 'tan' => '√3', 'csc' => '2√3/3', 'sec' => '2', 'cot' => '1/√3'],
        90 => ['sin' => '1', 'cos' => '0', 'tan' => 'undefined', 'csc' => '1', 'sec' => 'undefined', 'cot' => '0'],
        180 => ['sin' => '0', 'cos' => '-1', 'tan' => '0', 'csc' => 'undefined', 'sec' => '-1', 'cot' => 'undefined'],
        270 => ['sin' => '-1', 'cos' => '0', 'tan' => 'undefined', 'csc' => '-1', 'sec' => 'undefined', 'cot' => '0'],
        360 => ['sin' => '0', 'cos' => '1', 'tan' => '0', 'csc' => 'undefined', 'sec' => '1', 'cot' => 'undefined']
    ];

    function handleMathFunction($func)
    {
        $num = floatval($_SESSION['currentNumber']);

        switch ($func) {
            // Regular trigonometric functions
            case 'sin':
            case 'cos':
            case 'tan':
            case 'csc':
            case 'sec':
            case 'cot':
                handleTrigonometric($func, $num);
                break;
                
            // Inverse trigonometric functions
            case 'arcsin':
                $_SESSION['currentExpression'] = "arcsin($num) =";
                if ($num >= -1 && $num <= 1) {
                    $_SESSION['currentNumber'] = number_format(asin($num) * 180 / M_PI, 8);
                } else {
                    $_SESSION['currentNumber'] = 'Error';
                }
                break;
            case 'arccos':
                $_SESSION['currentExpression'] = "arccos($num) =";
                if ($num >= -1 && $num <= 1) {
                    $_SESSION['currentNumber'] = number_format(acos($num) * 180 / M_PI, 8);
                } else {
                    $_SESSION['currentNumber'] = 'Error';
                }
                break;
            case 'arctan':
                $_SESSION['currentExpression'] = "arctan($num) =";
                $_SESSION['currentNumber'] = number_format(atan($num) * 180 / M_PI, 8);
                break;
            case 'arccsc':
                $_SESSION['currentExpression'] = "arccsc($num) =";
                if ($num != 0) {
                    $_SESSION['currentNumber'] = number_format(asin(1/$num) * 180 / M_PI, 8);
                } else {
                    $_SESSION['currentNumber'] = 'Error';
                }
                break;
            case 'arcsec':
                $_SESSION['currentExpression'] = "arcsec($num) =";
                if ($num != 0) {
                    $_SESSION['currentNumber'] = number_format(acos(1/$num) * 180 / M_PI, 8);
                } else {
                    $_SESSION['currentNumber'] = 'Error';
                }
                break;
            case 'arccot':
                $_SESSION['currentExpression'] = "arccot($num) =";
                $_SESSION['currentNumber'] = number_format((M_PI/2 - atan($num)) * 180 / M_PI, 8);
                break;
                
            // Other functions
            case 'sqrt':
                $_SESSION['currentExpression'] = "√($num) =";
                $_SESSION['currentNumber'] = $num >= 0 ? sqrt($num) : 'Error';
                break;
            case 'cbrt':
                $_SESSION['currentExpression'] = "∛($num) =";
                $_SESSION['currentNumber'] = pow($num, 1/3);
                break;
            case 'square':
                $_SESSION['currentExpression'] = "($num)² =";
                $_SESSION['currentNumber'] = pow($num, 2);
                break;
            case 'cube':
                $_SESSION['currentExpression'] = "($num)³ =";
                $_SESSION['currentNumber'] = pow($num, 3);
                break;
            case 'log':
                $_SESSION['currentExpression'] = "log($num) =";
                $_SESSION['currentNumber'] = $num > 0 ? log10($num) : 'Error';
                break;
            case 'ln':
                $_SESSION['currentExpression'] = "ln($num) =";
                $_SESSION['currentNumber'] = $num > 0 ? log($num) : 'Error';
                break;
        }
        $_SESSION['newNumber'] = true;
    }

    function handleTrigonometric($func, $angle)
    {
        global $specialAngles;

        $normalizedAngle = fmod(fmod($angle, 360) + 360, 360);

        if (isset($specialAngles[$normalizedAngle])) {
            $_SESSION['currentNumber'] = $specialAngles[$normalizedAngle][$func];
            if ($_SESSION['currentNumber'] === 'undefined') {
                $_SESSION['currentNumber'] = 'Error';
            }
        } else {
            $radians = $angle * M_PI / 180;
            switch ($func) {
                case 'sin':
                    $_SESSION['currentNumber'] = sin($radians);
                    break;
                case 'cos':
                    $_SESSION['currentNumber'] = cos($radians);
                    break;
                case 'tan':
                    $_SESSION['currentNumber'] = abs(cos($radians)) < 1e-10 ? 'Error' : tan($radians);
                    break;
                case 'csc':
                    $_SESSION['currentNumber'] = abs(sin($radians)) < 1e-10 ? 'Error' : 1 / sin($radians);
                    break;
                case 'sec':
                    $_SESSION['currentNumber'] = abs(cos($radians)) < 1e-10 ? 'Error' : 1 / cos($radians);
                    break;
                case 'cot':
                    $_SESSION['currentNumber'] = abs(sin($radians)) < 1e-10 ? 'Error' : cos($radians) / sin($radians);
                    break;
            }

            if ($_SESSION['currentNumber'] !== 'Error') {
                $_SESSION['currentNumber'] = number_format($_SESSION['currentNumber'], 8);
            }
        }

        $_SESSION['currentExpression'] = "$func($angle) =";
    }
?>