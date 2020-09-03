<?php

define("LETTER_COUNT", 200);

// инициализация переменных
$articleText = file_get_contents("article.txt");
$articleLink = "https://some-site.com/article/123456789";

// формирование анонса
$articlePreview = get_preview($articleText, $articleLink);

/**
 * Генерация анонса статьи со ссылкой на источник
 *
 * @param $articleText
 * @param $articleLink
 * @return string
 */
function get_preview($articleText, $articleLink)
{
    // обрезка статьи, инициализация переменных
    $preview = trim(substr($articleText, 0, LETTER_COUNT));
    $preview = strip_tags($preview);
    $preview = htmlspecialchars($preview);
    $letter_i = strlen($preview);
    $word_count = 0;

    // обрезка завершающих символов, которые
    // не являются буквами
    while ( !is_letter($preview[$letter_i])) {
        $letter_i--;
    }
    $letter_i++;
    $preview = substr($preview, 0, $letter_i);

    // вычисление позиции начала третьего с конца слова
    while ($word_count < 3) {
        $letter = $preview[$letter_i];
        if ( !is_in_word($letter)) {
            $word_count++;
        }
        $letter_i--;
    }
    $letter_i += 2;

    // вырезаем и оборачиваем в ссылку последние 3 слова
    $link_text = substr($preview, $letter_i, strlen($preview)) . "...";
    $link = "<a href='$articleLink'>$link_text</a>";
    // собираем анонс
    $preview = substr($preview, 0, $letter_i) . $link;

    return htmlspecialchars_decode($preview);
}

/**
 * Является ли символ частью слова (не пробелом)
 *
 * @param $char
 * @return bool
 */
function is_in_word($char)
{
    return !(ord($char) == ord(" ") || ord($char) == ord("&nbsp;"));
}

/**
 * Является ли символ буквой русского или английского алфавита
 *
 * @param $char
 * @return bool
 */
function is_letter($char)
{
    $ord_char = ord(strtolower($char));
    return ($ord_char >= ord('a')) && ($ord_char <= ord('z')) ||
        ($ord_char >= ord('а')) && ($ord_char <= ord('я'));
}

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Task 1</title>
    <style>
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #eee;
            border-radius: 20px;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Anons</h2>
    <p><?= $articlePreview; ?></p>
    <h2>Text</h2>
    <p><?= $articleText; ?></p>
</div>
</body>
</html>

