<?php
$lifetime=2592000;
session_set_cookie_params($lifetime);
session_start();
setcookie(session_name(),session_id(),time()+$lifetime);

include ("libo.php");
include ("ilibo.php");

saveToIMenu($_GET['file']);
$fts="files/".$_GET['file'].".txt";
if ($_POST) {

    file_put_contents($fts, $_POST['vp']);
}

if (!file_exists($fts)) {
$fp = fopen($fts, "w+");
fwrite($fp, "Выписка     %рейтинг_цифр:300 парам_симвл:изучено");
//fwrite($fp, "сортировка  %рейтинг_цифр:200 парам_симвл:тест\n");
//fwrite($fp, "сохранение  %рейтинг_цифр:100 парам_симвл:тест\n");
//fwrite($fp, "отдельно для каждого устройства  %рейтинг_цифр:50 парам_симвл:изучено\n");
fclose($fp);
  }



$get=new getNu($fts);


?>
<!DOCTYPE html>
<html>

<head>
   <link rel="stylesheet" media="all" href="https://s3.amazonaws.com/dynatable-docs-assets/css/reset.css" />
   <link rel="stylesheet" media="all" href="https://s3.amazonaws.com/dynatable-docs-assets/css/bootstrap-2.3.2.min.css" />
   <script type='text/javascript' src='https://s3.amazonaws.com/dynatable-docs-assets/js/jquery-1.9.1.min.js'></script>
   <link rel="stylesheet" media="all" href="https://s3.amazonaws.com/dynatable-docs-assets/css/jquery.dynatable.css" />

<script type='text/javascript' src='https://s3.amazonaws.com/dynatable-docs-assets/js/jquery.dynatable.js'></script>

   <script type='text/javascript' src='https://s3.amazonaws.com/dynatable-docs-assets/js/highcharts.js'></script>

  <style>
        tr {height: 20px;}
  </style>

</head>

<body>
<button><a href="index.php">Home</a></button>
<?php  // print_r(session_id()); ?>
<?php   print_r($_GET['file']); ?>
  <table id="my-final-table" style="width: 600px;">
    <thead>
      <?php echo $get->head(); ?>
    </thead>
    <tbody>
    </tbody>
  </table>


<pre id="json-records" style="display: none;">
<?php
//echo $get->JSON();
 $js=json_decode($get->JSON());
 echo json_encode( $js,JSON_UNESCAPED_UNICODE);

 ?>
</pre>
<button id="edit">Редактор</button>
<form id="frm"  method="post">

<textarea id="vp" type="text" name="vp" style="border:2px solid green; height: 200px; width: 600px;" contenteditable="true" >
<?php echo $get->vp(); ?>
</textarea>
<input type="submit" value="coхранить"  >
</form>

<pre style="<?php echo $get->ch();?>"   >
<?php $get->ext(); ?>
</pre>


<script>
$( "#frm" ).toggle( "slow" );

$( "#edit" ).click(function() {
  $( "#frm" ).toggle( "slow" );
});



 var $records = $('#json-records'),
  myRecords = JSON.parse($records.text());
$('#my-final-table').dynatable({
dataset: {
  records: myRecords
}
});

</script>


</body>

</html>
