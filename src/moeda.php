<?php

// Protocol Corporation Ltda.
// https://github.com/FabioCarpi/PHP-Live/
// Revisão 1 de 03/10/2016

function Moeda($N, $Tipo = "R", $Negativo = null, $Positivo = null){
  $retorno = "";
  $especial = false;
  if(!is_null($Negativo) and $N < 0){
    $especial = true;
    $retorno = "<span style=\"color:#" . $Negativo . "\">";
  }
  if(!is_null($Positivo) and $N > 0){
    $especial = true;
    $retorno = "<span style=\"color:#" . $Positivo . "\">";
  }
  $retorno .= $Tipo;
  if(!empty($Tipo)){
    $retorno .= "$ ";
  }
  $retorno .= number_format($N, 2, ",", ".");
  if($especial == true){
    $retorno .= "</span>";
  }
  return $retorno;
}

function Extenso($N){
  if(!file_exists("PhpLive-StrrSplit.php")){
    $arquivo = file_get_contents("https://raw.githubusercontent.com/FabioCarpi/PHP-Live/master/StrrSplit.php"));
    file_put_contents("PhpLive-StrrSplit.php", $arquivo);
  }
  require_once("PhpLive-StrrSplit.php");

  $Retorno = "";
  $Neg = false;
  $Uni = array(null, "hum", "dois", "três", "quatro",
      "cinco", "seis", "sete", "oito", "nove");
  $Dez0 = array(null, "dez", "vinte", "trinta", "quarenta",
      "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
  $Dez10 = array(null, "onze", "doze", "treze", "quatorze",
      "quinze", "dezesseis", "dezessete", "dezoito", "dezenove");
  $Cen0 = array(null, "cem", "duzentos", "trezentos", "quatrocentos",
      "quinhentos", "seissentos", "setecentos", "oitocentos", "novecentos");
  $Cen10 = array(null, "cento");
  $CasSin = array(null, "mil", "milhão", "bilhão", "trilhão");
  $CasPlu = array(null, null, "milhões", "bilhões", "trilhões");

  //acerta a entrada
  if($N < 0){
    $Neg = true;
  }
  if(strpos($N, ".") === false){
    $N .= ".00";
  }
  $centavos = explode(".", $N);
  $reais = StrrSplit($centavos[0], 3);
  $centavos = $centavos[1];
  if(strlen($centavos) == 1){
    $centavos .= 0;
  }

  foreach($reais as $i => $n){
    $n = str_pad($n, 3, 0, STR_PAD_LEFT);
    $n = str_split($n);
    //centenas
    if($n[0] > 0){
      if($n[1] > 0){
        if($n[0] == 1){
	        $Retorno .= $Cen10[$n[0]] . " e ";
	      }else{
	        $Retorno .= $Cen0[$n[0]] . " e ";
	      }
      }else{
	      $Retorno .= $Cen0[$n[0]];
      }
    }
    //dezenas
    if($n[1] > 0){
      if($n[2] > 0){
	      if($n[1] == 0){
	        $Retorno .= $Uni[$n[2]];
	      }elseif($n[1] == 1){
	        $Retorno .= $Dez10[$n[2]];
	      }else{
	        $Retorno .= $Dez0[$n[1]] . " e " . $Uni[$n[2]];
	      }
      }elseif($n[1] == 1){
	      $Retorno .= $Dez0[1];
      }else{
	      $Retorno .= $Dez0[$n[1]];
      }
    }
    //unidade
    if($n[1] == 0 and $n[2] > 0){
      $Retorno .= $Uni[$n[2]];
    }

    if(count($reais) > 1 or $reais[0] > 0){
      $count = count($reais);
      if($i == $count - 1){
	      if($n[0] == 0 and $n[1] == 0 and $n[2] == 1){
	        $Retorno .= " real";
	      }else{
	        $Retorno .= " reais";
	      }
      }elseif($i == $count - 2){
        $Retorno .= " " . $CasSin[1] . ", ";
      }elseif($i == $count - 3){
	      if($n[0] == 0 and $n[1] == 0 and $n[2] == 1){
	        $Retorno .= " " . $CasSin[2] . ", ";
	      }else{
	        $Retorno .= " " . $CasPlu[2] . ", ";
	      }
      }elseif($i == $count - 4){
	      if($n[0] == 0 and $n[1] == 0 and $n[2] == 1){
	        $Retorno .= " " . $CasSin[3] . ", ";
	      }else{
	        $Retorno .= " " . $CasPlu[3] . ", ";
	      }
      }elseif($i == $count - 5){
	      if($n[0] == 0 and $n[1] == 0 and $n[2] == 1){
	        $Retorno .= " " . $CasSin[4] . ", ";
	      }else{
	        $Retorno .= " " . $CasPlu[4] . ", ";
	      }
      }
    }
  }

  //centavos
  if($centavos > 1){
    if(count($reais) > 1 or $reais[0] > 0){
      $Retorno .= " e ";
    }
    $centavos = str_split($centavos);
    if($centavos[0] > 0){
      if($centavos[1] > 0){
        if($centavos[0] == 0){
          $Retorno .= $Uni[$centavos[1]];
        }elseif($centavos[0] == 1){
          $Retorno .= $Dez10[$centavos[1]];
        }else{
          $Retorno .= $Dez0[$centavos[0]] . " e " . $Uni[$centavos[1]];
        }
      }elseif($centavos[0] == 1){
        $Retorno .= $Dez0[0];
      }else{
        $Retorno .= $Dez0[$centavos[0]];
      }
    }else{
      $Retorno .= $Uni[$centavos[1]];
    }
    $Retorno .= " centavos";
  }

  if($Neg){
    $Retorno .= " negativos";
  }

  return $Retorno;
}