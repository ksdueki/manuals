<?php


$body = "<pre>あいうえお</pre>";


function PreToHtml($pre_html)
{
  $strip_pre = str_replace(["<pre>", "</pre>"], "", $pre_html);
  // nl2br
  $htmled = nl2br($strip_pre);
  return $htmled;
}

function CodeToHtml($code_html)
{
  $strip_code = str_replace(["<code>", "</code>"], "", $code_html);
  $htmled = nl2br($strip_code);
  return $htmled;
}

$converted_array = [];
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML( mb_convert_encoding($body, 'HTML-ENTITIES', 'UTF-8'));

$pre_tags = $dom->getElementsByTagName('pre');
foreach ($pre_tags as $pre) {
  $converted_array[] =$dom->saveHTML($pre);
}
$code_tags = $dom->getElementsByTagName('code');
foreach ($code_tags as $code) {
  $converted_array[] = $dom->saveHTML($code);
}
$converted = "<div>" . implode("", $converted_array) . "</div>";
echo ($converted);
