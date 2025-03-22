<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator Pemula</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <?php
    include("function.php");
    ?>
    <div class="<?php echo $_SESSION['calculatorMode'] === 'basic' ? 'w-[320px]' : 'w-[460px]'; ?>">
        <form method="POST" class="mb-4">
            <input type="hidden" name="switchMode" value="1">
            <button type="submit"
                class="w-full bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition duration-200 shadow-md">
                Ganti mode ke <?php echo $_SESSION['calculatorMode'] === 'basic' ? 'Scientific' : 'Basic'; ?>
            </button>
        </form>
        <div class="bg-[#4a4a4a] p-4 rounded-lg shadow-xl">
            <div class="bg-[#c4d4a9] h-16 mb-4 rounded-md p-2 flex flex-col justify-between">
                <div class="text-sm h-6 overflow-hidden"><?php echo $_SESSION['currentExpression']; ?></div>
                <div class="text-right text-2xl h-8 overflow-hidden"><?php echo $_SESSION['currentNumber']; ?></div>
            </div>

            <?php if ($_SESSION['calculatorMode'] === 'basic') { ?>
                <div class="grid grid-cols-4 gap-2">
                    <form method="POST" class="contents">
                        <input type="hidden" name="mode" value="<?php echo $_SESSION['calculatorMode']; ?>">
                        <?php
                        include("buttonbasic.php");
                        ?>
                    </form>
                </div>
            <?php } else { ?>
                <div class="grid grid-cols-7 gap-2">
                    <form method="POST" class="contents">
                        <input type="hidden" name="mode" value="<?php echo $_SESSION['calculatorMode']; ?>">
                        <?php
                        include("buttonscientific.php");
                        ?>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>