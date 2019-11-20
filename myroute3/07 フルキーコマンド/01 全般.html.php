<html>

<head>
    <meta http-equiv='Content-Language' content='ja'>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>7-1. 全般</title>
</head>

<body>
<ol>

<?php

function oneKey($key)
{
    $ar_decorated = array_map(
        function ($x) {
            return "<span class='key'>{$x}</span>";
        },
        explode("+", $key)
    );
    return implode("+", $ar_decorated);
}

function toKeysHtml($keys)
{
    $ar_keys = array_map(
        function ($x) {
            return oneKey($x);
        },
        $keys
    );
    return implode("/", $ar_keys);
}

function makeLink($data)
{
    $tag = "";
    $desc = array_shift($data);
    return "<li>{$desc} " . toKeysHtml($data) . "</li>";
}

$tsv = [
    ["マイルートの終了", "Alt+F4"],
    ["マニュアル", "F1"],
    ["マイルートの終了", "Alt+F4"],
    ["画面の拡大率を上げる", "F6", "Alt+PageDown"],
    ["画面の拡大率を下げる", "Alt+PageUp"],
    ["音声スピード切り替え", "F7"],
    ["一覧情報の読み上げ", "Alt+F1"],
];

foreach ($tsv as $key => $value) {
    echo makeLink($value), PHP_EOL;
}
?>

</ol>
</body>

</html>