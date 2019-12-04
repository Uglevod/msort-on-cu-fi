<?php
session_set_cookie_params(2592000);
session_start();



if ($_GET) {

    setcookie(session_name(), $_GET['ssid'],time()+2592000);
} else {setcookie(session_name(),session_id(),time()+2592000);}


include ("ilibo.php");

$fts="sesfiles/".session_id().".txt";

//var_dump($_POST);

if ( $_POST) {

    file_put_contents($fts, $_POST['sp']);
}


if (!file_exists($fts)) {
$fp = fopen($fts, "w+");
fclose($fp); }

$iet=new getIU($fts);

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
   <link rel="stylesheet" media="all" href="https://s3.amazonaws.com/dynatable-docs-assets/css/reset.css" />
   <link rel="stylesheet" media="all" href="https://s3.amazonaws.com/dynatable-docs-assets/css/bootstrap-2.3.2.min.css" />
   <script type='text/javascript' src='https://s3.amazonaws.com/dynatable-docs-assets/js/jquery-1.9.1.min.js'></script>
   <link rel="stylesheet" media="all" href="https://s3.amazonaws.com/dynatable-docs-assets/css/jquery.dynatable.css" />
  <script type='text/javascript' src='https://s3.amazonaws.com/dynatable-docs-assets/js/jquery.dynatable.js'></script>
  <script type='text/javascript' src='https://s3.amazonaws.com/dynatable-docs-assets/js/highcharts.js'></script>
 </head>
<body>
<div class="headr">
  <form>
    <label>+2xreload page to change ssid</label>
    <input type="text" name="ssid" value="<?php echo session_id(); ?>" style="margin: 0px;">
    <input type="submit">
  </form>
</div>
<div class="con" style="display:flex; flex-direction: column;" >
  <?php echo $iet->getBts();?>
  <button><a href="page.php?file=<?php echo $iet->randSt();?>">new</a> </button>


</div>
<button id="edit">Редактор</button>
<form id="frm"  method="post">

<textarea id="sp" type="text" name="sp" style="border:2px solid green; height: 200px; width: 600px;" contenteditable="true" >
<?php echo $iet->getSp(); ?>
</textarea>
<input type="submit" value="coхранить"  >
</form>

<script>
$( "#frm" ).toggle( "slow" );

$( "#edit" ).click(function() {
  $( "#frm" ).toggle( "slow" );
});
</script>
</body>

</html>
