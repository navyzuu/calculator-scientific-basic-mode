<?php
    if (!isset($_SESSION['currentExpression'])) {
        $_SESSION['currentExpression'] = '';
        $_SESSION['currentNumber'] = '0';
        $_SESSION['lastOperation'] = null;
        $_SESSION['newNumber'] = true;
        $_SESSION['calculatorMode'] = 'basic';
        $_SESSION['secondaryInput'] = null;
        $_SESSION['waitingForSecondInput'] = false;
        $_SESSION['pendingOperation'] = null;
    }

    if (isset($_POST['switchMode'])) {
        $_SESSION['calculatorMode'] = $_SESSION['calculatorMode'] === 'basic' ? 'scientific' : 'basic';
    }

    if (isset($_POST['mode'])) {
        $_SESSION['calculatorMode'] = $_POST['mode'];
    }

    if (isset($_POST['backspace'])) {
        if (strlen($_SESSION['currentNumber']) > 1) {
            $_SESSION['currentNumber'] = substr($_SESSION['currentNumber'], 0, -1);
        } else {
            $_SESSION['currentNumber'] = '0';
            $_SESSION['newNumber'] = true;
        }
    }
?>