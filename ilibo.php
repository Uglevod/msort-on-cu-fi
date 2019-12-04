<?php

function saveToIMenu($file){

  $fts="sesfiles/".session_id().".txt";
  $lines=file($fts);
  $est=0;
  foreach ($lines as $key => $value) {
    if (stripos($value, $file)===false) {

    } else {  $est=1; }
  }

if ($est==0) {
  $fp = fopen($fts, "a+");
  fwrite($fp, "$file:Имя выписки\n");
  fclose($fp);
}

}










class getIU{
public $lines=array();

//------ construct
 public function __construct($name)
 {
  $this->lines=file($name);
  }

//------- rand function
  public function randSt() {

  return bin2hex(random_bytes(10));

  }
//-- gjkexftv yjgb получаем кнопки
  public function getBts(){
    foreach ($this->lines as $key => $value) {
      $ex=explode(":",trim($value));
      echo "<button><a href='page.php?file=".$ex[0]."'>$ex[1]</a> </button>";
    }

  }

public function getSp(){

  $ret="";
  foreach ($this->lines as $key => $value) {
      $ret=$ret.trim($value)."\n";
  }

  return $ret;
}



  }

?>
