<?php

namespace Src\Utilities;

/**
 * parseQuery
 *
 * @param "?key=val&..." pattern string
 * @param assoc array where ['key' => val,...]
 * */
function parseQuery($input)
{
  $cachedStrpos = strpos($input, "?");
  if ($cachedStrpos === false) return [];

  print $cachedStrpos;
  $input = substr($input, $cachedStrpos, strlen($input) - $cachedStrpos);
  $arr = explode('&', $input);
  $output = [];

  foreach ($arr as $pair) {
    $output[] = explode('=', $pair);
  }

  return $output;
}

function log($message)
{
  $message = date("H:i:s") . " - $message - " . PHP_EOL;
  print($message);
  flush();
  ob_flush();
}
