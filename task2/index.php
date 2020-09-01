<?php

if ( $_POST )
	$res = calculate();

function calculate() {
	$commit_amount = 0;
	// получаем количество ошибок и предупреждений из полей ввода
	$error_amount   = $_POST['errors'] ? $_POST['errors'] : 0;
	$warning_amount = $_POST['warnings'] ? $_POST['warnings'] : 0;

	// если количество ошибок нечетно, а предупреждений нет - исправить программу полностью невозможно
	if ( ( $error_amount % 2 == 1 ) && $warning_amount == 0 ) {
		return - 1;
	}

	// если количество предупреждений нечетно - доводим до четного количества
	// (исправляем 1 предупреждение за коммит, получаем 2)
	if ( $warning_amount % 2 == 1 ) {
		$commit_amount  += 1;
		$warning_amount += 1;
	}
	// проверяем, будет ли ошибок четное число если исправить все предупреждения
	// если нет - добавляем два коммита и, соответственно, две ошибки
	if ( ( $error_amount + ( $warning_amount / 2 ) ) % 2 == 1 ) {
		$commit_amount  += 2;
		$warning_amount += 2;
	}

	// переводим все предупреждения в ошибки
	$commit_amount += $warning_amount / 2;
	$error_amount  += $warning_amount / 2;
	// исправляем все ошибки
	$commit_amount += $error_amount / 2;

	return $commit_amount;
}

?>


<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task 2 | Braind School</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="center">
    <h1>Task 2</h1>
    <p>Help Petya defeat errors and warnings</p>
    <form action="/" method="post">
        <h2>Input</h2>
        <div class="row">
            <div class="form-field-2">
                <label for="inpErrors">Errors amount</label>
                <input id="inpErrors" name="errors" class="some-field" type="number" min="0" step="1"
                       value="<?= $_POST['errors'] ? $_POST['errors'] : 0; ?>">
            </div>
            <div class="form-field-2">
                <label>Warnings amount</label>
                <input id="inpWarnings" name="warnings" class="some-field" type="number" min="0" step="1"
                       value="<?= $_POST['warnings'] ? $_POST['warnings'] : 0; ?>">
            </div>
        </div>
        <button type="submit" class="btn">Calculate</button>
    </form>
    <h2>Output</h2>
    <div id="result" class="some-field"><?= $res ? $res : "" ?></div>
</div>

</body>
</html>