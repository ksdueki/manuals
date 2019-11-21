<?php


$request_body = file_get_contents('php://input'); //送信されてきたbodyを取得(JSON形式）
$data = json_decode($request_body,true); // デコード

$body = $data['body'];


function PreToHtml($pre_html)
{
  $strip_pre = str_replace(["<pre>", "</pre>"], "", $pre_html);
  // nl2br
  $htmled = nl2br($strip_pre);
  return $htmled;
}


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

function CodeToHtml($code_html)
{
  $strip_code = str_replace(["<code>", "</code>"], "", $code_html);
  $lines = explode("\n", $strip_code);

  $li_items = [];
  foreach ($lines as $line) {
    if(!empty(trim($line))){
      $li_items[] =makeLink(explode(",", $line));
    }
  }
  $ol = "<ol>" . implode("", $li_items) . "</ol>";
  $htmled = $ol;//nl2br($strip_code);
  return $htmled;
}

$converted_array = [];
$dom = new DOMDocument();
// $dom->loadHTML($body);
$dom->loadHTML( mb_convert_encoding($body, 'HTML-ENTITIES', 'UTF-8'));

$pre_tags = $dom->getElementsByTagName('pre');
foreach ($pre_tags as $pre) {
  $converted_array[] = PreToHtml($dom->saveHTML($pre));
}
$code_tags = $dom->getElementsByTagName('code');
foreach ($code_tags as $code) {
  $converted_array[] = CodeToHtml($dom->saveHTML($code));
}
$converted = "<div>" . implode("", $converted_array) . "</div>";
echo json_encode($converted);
