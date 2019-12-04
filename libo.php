<?php

class getNu{
public $lines=array();

//------ construct
 public function __construct($name)
 {
  $this->lines=file($name);
  }

//------- vp function
  public function vp() {

    $ret="";
    foreach ($this->lines as $key => $value) {
        $ret=$ret.trim($value)."\n";
    }

    return $ret;


      }
//------- get json function
public function JSON()
{
  $lines = $this->lines;
  $text="";
  $header="";
  $json=array("[");
// Осуществим проход массива и выведем содержимое в виде HTML-кода вместе с номерами строк.
foreach ($lines as $line_num => $line) {
  //  echo " $line  \n";

    $line = preg_replace('|[\s]+|s', ' ', $line);
    $line = trim($line);
    $bmass=explode(" ",$line);

    array_push($json,"{");

    foreach ($bmass as $key => $value){
      $value=trim($value);
      if (stripos($value, ":")===false) {
        $text=trim($text." ".$value)  ;
        if ($key==count($bmass)-1) {array_push($json,"\"text\":\"$text\""); } else {array_push($json,"\"text\":\"$text\","); }

      } else {

      $mass=explode (":",$value);
      $op=$mass[0];
      $zna=$mass[1];

      if (stripos($value, "%")===false) {$qo="\"";} else {$qo="";}

      if ($key==count($bmass)-1) {array_push($json,"\"$op\":".$qo.$zna.$qo); } else {array_push($json,"\"$op\":".$qo.$zna.$qo.","); }

            }


    }
    if ($line_num==count($lines)-1) {array_push($json,"}");} else {array_push($json,"},"); }



  $text="";

}

array_push($json,"]");
$ret="";
foreach ($json as $key => $value) {
    $ret=$ret.$value."\n";
}

return $ret;



}
//// -------------get head


public function  head()
{
  $lines = $this->lines;
  $text="";
  $header=array();
  $json=array();
// Осуществим проход массива и выведем содержимое в виде HTML-кода вместе с номерами строк.
foreach ($lines as $line_num => $line) {
  //  echo " $line  \n";

    $line = preg_replace('|[\s]+|s', ' ', $line);
    $line = trim($line);
    $bmass=explode(" ",$line);



    foreach ($bmass as $value){
      $value=trim($value);
      if (stripos($value, ":")===false) {

      } else {

      $mass=explode (":",$value);
      $op=$mass[0];
      $zna=$mass[1];
        array_push($header,"$op");
            }


    }

  $text="";

}

$header= array_unique($header);
$ret="<th>text</th>\n";
foreach ($header as $key => $value) {
    $ret=$ret."<th>$value</th>\n";
}

return $ret;
}
/// ----------naked head
public function  nhead()
{
  $lines = $this->lines;
  $text="";
  $header=array();
  $json=array();
// Осуществим проход массива и выведем содержимое в виде HTML-кода вместе с номерами строк.
foreach ($lines as $line_num => $line) {
  //  echo " $line  \n";

    $line = preg_replace('|[\s]+|s', ' ', $line);
    $line = trim($line);
    $bmass=explode(" ",$line);



    foreach ($bmass as $value){
      $value=trim($value);
      if (stripos($value, ":")===false) {

      } else {

      $mass=explode (":",$value);
      $op=$mass[0];
      $zna=$mass[1];
        array_push($header,"$op");
            }


    }

  $text="";

}

$header= array_unique($header);
$ret="text\n";
foreach ($header as $key => $value) {
    $ret=$ret."$value\n";
}

return $header;
}



//// чекаем наличие отсутвия параметров
public function  ch()
{
  $js=json_decode($this->JSON(),true);
  $nh=$this->nhead();

  // если нет заголовка то добавляем
      $signal=0;
      foreach ($js as $key => $value) {
           foreach ($nh as $nhkey => $nhvalue) {
              if (!array_key_exists($nhvalue, $js[$key]))
              {
                  $signal=1;
                  if (stripos($nhvalue, "%")===false) {
                      $js[$key]["$nhvalue"]="none";
                    } else {
                        $js[$key]["$nhvalue"]=0;

                    }

               }
           }
      }
//echo $signal;
    if ($signal==0) {$ret="display: none;";} else {$ret="border:2px solid yellow;";}
  echo $ret;
}
/// выводим расширенный дополненный отсвутв параметрами список
public function  ext()
{

  $js=json_decode($this->JSON(),true);
  $nh=$this->nhead();

  //самое длинное текст
    $maxlen=0;

    foreach ($js as $key => $value) {

          if  (strlen($js[$key]['text'])>$maxlen) {$maxlen=strlen($js[$key]['text']);}

    }
    $maxlen+=4;

    // если нет заголовка то добавляем
        $signal=0;
        foreach ($js as $key => $value) {
             foreach ($nh as $nhkey => $nhvalue) {
                if (!array_key_exists($nhvalue, $js[$key]))
                {
                    $signal=1;
                    if (stripos($nhvalue, "%")===false) {
                        $js[$key]["$nhvalue"]="none";
                      } else {
                          $js[$key]["$nhvalue"]=0;

                      }

                 }
             }
        }
    // вывод дополненного
    foreach ($js as $key => $value) {

      foreach ($value as $akey => $avalue) {
      //echo $maxlen-strlen($avalue);

        if ($akey=="text") { echo  $avalue.$this->genSp1(($maxlen-strlen($avalue))/2 );  }
        else {
           echo $akey.":".$avalue."  ";
          }


      }
    echo "<br>";
    }

}

/// генерим пробелы

function genSp1($num)
{
  $sp="";
  for($i=0;$i<$num;$i++) {$sp=$sp." ";}
  return $sp;
}



}



?>
