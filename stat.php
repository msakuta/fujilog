<?php header("Content-Type:text/html;charset=SHIFT_JIS"); ?>
<?php
htmlHeader();

$freq = 10;
$maxc = 50;

if($_GET['freq'])
	$freq = $_GET['freq'];
if($_GET['maxc'])
	$maxc = $_GET['maxc'];

?>
<h1>Mt. Fuji Camera Statistics</h1>
<form mthod="GET" action="stat.php">
Interval 
<input name="freq" type="edit" value=<?php echo '"' . $freq . '"'; ?> >min.<br>
Count <input name="maxc" type="edit" value=<?php echo '"' . $maxc . '"'; ?> ><br>
<input type="submit">
</form>
<h2>Description</h2>
<p>This page shows statistics of the Mt.Fuji camera images.</p>
<p>Specifically, all channel's mean and standard deviation of all pixels
are averaged for each image.</p>
<p>It hardly tells anything about the image's content, but at least we
can tell if it's day or night.</p>
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

	echo "<table border='1'><tr><th>Image</th><th>Mean</th><th>Stdev</th></tr>\n";
	for($i = count($a) - $maxc; $i < count($a); $i++){
		$img = new Imagick(trim($a[$i]));
		$stat = $img->getImageChannelMean(Imagick::CHANNEL_ALL);
//		$stat = $img->getImageChannelStatistics();
		echo '<tr><td><a href="' . trim($a[$i]) . '">' .
			'<img src="' . trim($a[$i]) . '" width="64" height="48"></a></td>' .
			'<td>' . $stat["mean"] . '</td>' .
			'<td>' . $stat["standardDeviation"] . '</td>' .
			"</tr>\n";
	}
	echo "</table>";
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
