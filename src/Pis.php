<?php
// Protocol Corporation Ltda.
// https://github.com/FabioCarpi/PHP-Live/
// Revisão 2 de 29/03/2014

function Pis($Pis) {
  $Pis = str_replace(".", "", $Pis);
  $Pis = str_replace("-", "", $Pis);
  if (strlen($Pis) != 11) {
    return false;
  }
  $Pos = array(3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
  $mult = 0;
  for ($i = 0; $i < 10; $i++) {
    $mult += substr($Pis, $i, 1) * $Pos[$i];
  }
  $mult %= 11;
  if ($mult <= 1) {
    $mult = 0;
  } else {
    $mult = 11 - $mult;
  }
  if ($mult == substr($Pis, 10)) {
    return true;
  } else {
    return false;
  }
}