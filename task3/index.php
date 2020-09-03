<?php

if ( $_POST )
	$res = calculate();

function calculate() {
    // получаем данные из формы
	$n   = $_POST['n'] ? $_POST['n'] : 0;
	$k   = $_POST['k'] ? $_POST['k'] : 0;

	// проверка данных
	if ($n <= 0)
		return "out of range: N less or equal then zero";
	if ($k <= 0)
	    return "out of range: K less or equal then zero";
	if ($k > $n)
	    return "out of range: k more than n";

	// заполняем массив
	$arr = range( 1, $n );
	// сортируем массив
	$arr = shaker_sort( $arr );

	// ищем и возвращаем позицию искомого числа
	return array_search( $k, $arr ) + 1;
}

// шейкерная сортировка
function shaker_sort( $array ) {
    // преобразуем числа в строки, чтобы сравнивать по правилам строк
	foreach ( $array as $key => $item ) {
        $array[$key] = strval($item);
    }

	if (count($array) == 1)
	    return $array;

	$b = true;
	$beg = -1;
	$end = count($array) - 1;
	while ($b) {
	    $b = false;
	    $beg++;
	    for ($i = $beg; $i < $end; $i++) {
	        if (strcasecmp($array[$i],$array[$i+1]) > 0) {
	            $t = $array[$i];
		        $array[$i] = $array[$i+1];
		        $array[$i+1] = $t;
		        $b = true;
            }
        }
	    if (!$b) break;
	    $end--;
	    for ($i = $end; $i > $beg; $i--) {
	        if (strcasecmp($array[$i-1],$array[$i]) > 0) {
		        $t = $array[$i];
		        $array[$i] = $array[$i-1];
		        $array[$i-1] = $t;
		        $b = true;
            }
        }
    }

    // преобразуем обратно в числа
	foreach ( $array as $key => $item ) {
		$array[$key] = (int) $item;
	}

	return $array;
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task 3 | Braind School</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="center">
    <h1>Task 3</h1>
    <p>Strange math</p>
    <form action="index.php" method="post">
        <h2>Input</h2>
        <div class="row">
            <div class="form-field-2">
                <label for="inpErrors">N</label>
                <input id="inpErrors" name="n" class="some-field" type="number" min="0" step="1"
                       value="<?= $_POST['n'] ? $_POST['n'] : 0; ?>">
            </div>
            <div class="form-field-2">
                <label>K</label>
                <input id="inpWarnings" name="k" class="some-field" type="number" min="0" step="1"
                       value="<?= $_POST['k'] ? $_POST['k'] : 0; ?>">
            </div>
        </div>
        <button type="submit" class="btn">Calculate</button>
    </form>
    <h2>Output</h2>
    <div id="result" class="some-field">
        <?= $res ? $res : "" ;?>
    </div>
</div>

</body>
</html>