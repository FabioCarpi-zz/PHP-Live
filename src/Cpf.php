<?php

// Protocol Corporation Ltda.
// https://github.com/FabioCarpi/PHP-Live/
// Revisão 1 de 29/03/2014

function Cpf($Cpf) {
  $Cpf = str_replace(".", "", $Cpf);
  $Cpf = str_replace("-", "", $Cpf);
  $Erro = array("00000000000", "11111111111", "22222222222", "33333333333", "44444444444",
    "55555555555", "66666666666", "77777777777", "88888888888", "99999999999"
  );
  if (strlen($Cpf) != 11 or in_array($Cpf, $Erro)) {
    return false;
  }
  $Pos = array(10, 9, 8, 7, 6, 5, 4, 3, 2);
  $d1 = 0;
  for ($i = 0; $i < 9; $i++) {
    $d1 += substr($Cpf, $i, 1) * $Pos[$i];
  }
  $d1 %= 11;
  if ($d1 < 2) {
    $d1 = 0;
  } else {
    $d1 = 11 - $d1;
  }
  $Pos = array(11, 10, 9, 8, 7, 6, 5, 4, 3, 2);
  $d2 = 0;
  for ($i = 0; $i < 10; $i++) {
    $d2 += substr($Cpf . $d1, $i, 1) * $Pos[$i];
  }
  $d2 %= 11;
  if ($d2 < 2) {
    $d2 = 0;
  } else {
    $d2 = 11 - $d2;
  }
  if ($d1 . $d2 == substr($Cpf, 9)) {
    return true;
  } else {
    return false;
  }
}
