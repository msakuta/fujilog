<?php header("Content-Type:text/html;charset=SHIFT_JIS"); ?>
<?php
htmlHeader();

$freq = 10;
$maxc = 50;

// Prevent access to invalid keys
if(isset($_GET['freq']))
	$freq = $_GET['freq'];
if(isset($_GET['maxc']))
	$maxc = $_GET['maxc'];

?>
<h1>Mt. Fuji Camera Log</h1>
<form mthod="GET" action="list.php">
Interval 
<input name="freq" type="edit" value=<?php echo '"' . $freq . '"'; ?> >min.<br>
Count <input name="maxc" type="edit" value=<?php echo '"' . $maxc . '"'; ?> ><br>
<input type="submit">
</form>
<?php

$fp = fopen('upload.log', 'r');
if($fp){
	$a = array();
	$i = 0;
	while(FALSE != ($line = fgets($fp))){
		if($i++ % $freq == 0)
			$a[] = $line;
	}
	fclose($fp);

	echo $a[count($a) - $maxc] . ' to ' . $a[count($a) - 1] . '<br>';

	for($i = count($a) - $maxc; $i < count($a); $i++)
		echo '<a href="' . trim($a[$i]) . '"><image src="' .
			trim($a[$i]) . '", width=64, height=48></a>';
}
else{
	echo 'not found';
}
?>
<?php htmlFooter(); ?>

<?php function htmlHeader() { ?>


<HTML>
<HEAD>
<TITLE></TITLE>
</HEAD>
<BODY>

<?php } function htmlFooter() { ?>


</BODY>
</HTML>


<?php } ?>
