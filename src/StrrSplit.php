<?php
// Protocol Corporation Ltda.
// https://github.com/FabioCarpi/PHP-Live/
// Revisão 1 de 01/10/2016

function StrrSplit($String, $SplitLenght = 1) {
  $String = strrev($String);
  $String = str_split($String, $SplitLenght);
  $count = count($String);
  for ($i = 0; $i < $count; $i++) {
    $String[$i] = strrev($String[$i]);
  }
  $String = array_reverse($String);
  return $String;
}