<?php
// Protocol Corporation Ltda.
// https://github.com/FabioCarpi/PHP-Live/
// Revisão 1 de 27/12/2016

function PhpUpdate(){
  try{
    $pagina = @fopen("http://windows.php.net/download", "r");
    if(!is_null($pagina) and $pagina !== false){
      do{
        $linha = fgets($pagina);
      }while(strpos($linha, "id=\"php-7.1\"") === false);
      $pos = strpos($linha, "(");
      $linha = substr($linha, $pos + 1);
      $linha = substr($linha, 0, strpos($linha, ")"));
      echo "<a href=\"http://windows.php.net/download\" target=\"_blank\">" . $linha . "</a>";
    }
  }catch(Exception $e){
    echo "(Erro)";
  }
}