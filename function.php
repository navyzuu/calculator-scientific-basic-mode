<?php
    session_start();

    include("absolute.php");
    include("trigonometri.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['clear'])) {
            $_SESSION['currentExpression'] = '';
            $_SESSION['currentNumber'] = '0';
            $_SESSION['lastOperation'] = null;
            $_SESSION['newNumber'] = true;
            $_SESSION['waitingForSecondInput'] = false;
            $_SESSION['pendingOperation'] = null;
            $_SESSION['secondaryInput'] = null;
        } elseif (isset($_POST['number'])) {
            handleNumber($_POST['number']);
        } elseif (isset($_POST['operator'])) {
            handleOperator($_POST['operator']);
        } elseif (isset($_POST['calculate'])) {
            calculateResult();
        } elseif (isset($_POST['function'])) {
            handleMathFunction($_POST['function']);
        } elseif (isset($_POST['twoInputFunc'])) {
            handleTwoInputFunction($_POST['twoInputFunc']);
        } elseif (isset($_POST['confirmTwoInput'])) {
            confirmTwoInputOperation();
        }
    }

    function handleNumber($num)
    {
        if ($_SESSION['newNumber']) {
            $_SESSION['currentNumber'] = $num === '.' ? '0.' : $num;
            $_SESSION['newNumber'] = false;
        } else {
            if ($num === '.' && strpos($_SESSION['currentNumber'], '.') !== false) return;
            $_SESSION['currentNumber'] .= $num;
        }
    }

    function handleOperator($op)
    {
        if ($_SESSION['lastOperation']) calculateResult();
        $_SESSION['currentExpression'] = $_SESSION['currentNumber'] . ' ' . $op;
        $_SESSION['lastOperation'] = $op;
        $_SESSION['newNumber'] = true;
    }

    function calculateResult()
    {
        if (!$_SESSION['lastOperation']) return;

        $parts = explode(' ', $_SESSION['currentExpression']);
        $num1 = floatval($parts[0]);
        $num2 = floatval($_SESSION['currentNumber']);

        switch ($_SESSION['lastOperation']) {
            case '+':
                $_SESSION['currentNumber'] = $num1 + $num2;
                break;
            case '-':
                $_SESSION['currentNumber'] = $num1 - $num2;
                break;
            case '×':
                $_SESSION['currentNumber'] = $num1 * $num2;
                break;
            case '÷':
                $_SESSION['currentNumber'] = $num2 != 0 ? $num1 / $num2 : 'Error';
                break;
        }

        $_SESSION['currentExpression'] = '';
        $_SESSION['lastOperation'] = null;
        $_SESSION['newNumber'] = true;
    }

    function handleTwoInputFunction($func)
    {
        $_SESSION['pendingOperation'] = $func;
        $_SESSION['secondaryInput'] = $_SESSION['currentNumber'];
        $_SESSION['waitingForSecondInput'] = true;
        $_SESSION['newNumber'] = true;

        switch ($func) {
            case 'logBase':
                $_SESSION['currentExpression'] = "log<sub>{$_SESSION['currentNumber']}</sub>(x) =";
                break;
            case 'xPowY':
                $_SESSION['currentExpression'] = "({$_SESSION['currentNumber']})^y =";
                break;
            case 'yRootX':
                $_SESSION['currentExpression'] = "{$_SESSION['currentNumber']}^(1/y) =";
                break;
        }
    }

    function confirmTwoInputOperation()
    {
        if (!$_SESSION['waitingForSecondInput']) return;

        $x = floatval($_SESSION['secondaryInput']);
        $y = floatval($_SESSION['currentNumber']);

        switch ($_SESSION['pendingOperation']) {
            case 'logBase':
                if ($x <= 0 || $x == 1 || $y <= 0) {
                    $_SESSION['currentNumber'] = 'Error';
                } else {
                    $_SESSION['currentExpression'] = "log<sub>$x</sub>($y) =";
                    $_SESSION['currentNumber'] = log($y) / log($x);
                }
                break;

            case 'xPowY':
                $_SESSION['currentExpression'] = "($x)^$y =";
                $_SESSION['currentNumber'] = pow($x, $y);
                break;

            case 'yRootX':
                if ($y == 0 || ($x < 0 && $y % 2 == 0)) {
                    $_SESSION['currentNumber'] = 'Error';
                } else {
                    $_SESSION['currentExpression'] = "$y √ $x =";
                    $_SESSION['currentNumber'] = pow($x, 1 / $y);
                }
                break;
        }

        $_SESSION['waitingForSecondInput'] = false;
        $_SESSION['pendingOperation'] = null;
        $_SESSION['secondaryInput'] = null;
        $_SESSION['newNumber'] = true;
    }
?>