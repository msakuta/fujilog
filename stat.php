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
<canvas id="graph" width="400px" height="200px" style="width: 400px; height: 200px;"></canvas>
<p>
<?php

$fp = fopen('upload.log', 'r');
$stats = array();
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
		$stats[] = $stat;
	}
	echo "</table>";
}
else{
	echo 'not found';
}
?>

<script type="text/javascript">
var canvas;

var statsMean = [
<?php
for($i = 0; $i < count($stats); $i++){
	echo $stats[$i]["mean"] . ",\n";
}
?>
];

var statsDev = [
<?php
for($i = 0; $i < count($stats); $i++){
	echo $stats[$i]["standardDeviation"] . ",\n";
}
?>
];

window.onload = function(){
	canvas = document.getElementById("graph");
	draw();
}

function draw(){
	var ctx = canvas.getContext("2d");
	ctx.clearRect(0, 0, canvas.width, canvas.height);

	ctx.strokeStyle = "#000";
	ctx.beginPath();
	var maxi = Math.max.apply(null, statsMean);
	for(var i = 0; i < statsMean.length; i++)
		ctx.lineTo(i * canvas.width / statsMean.length,
		  canvas.height * (1. - statsMean[i] / maxi));
	ctx.stroke();

	ctx.font = "12px/2 sans-serif";
	ctx.beginPath();
	ctx.moveTo(canvas.width - 50, 10.5);
	ctx.lineTo(canvas.width - 40, 10.5);
	ctx.stroke();
	ctx.fillText("mean", canvas.width - 40, 15);

	ctx.strokeStyle = "#000";
	ctx.lineWidth = 2;
	ctx.beginPath();
	maxi = Math.max.apply(null, statsDev);
	for(var i = 0; i < statsDev.length; i++)
		ctx.lineTo(i * canvas.width / statsDev.length,
		  canvas.height * (1. - statsDev[i] / maxi));
	ctx.stroke();

	ctx.beginPath();
	ctx.moveTo(canvas.width - 50, 20);
	ctx.lineTo(canvas.width - 40, 20);
	ctx.stroke();
	ctx.fillText("stdev", canvas.width - 40, 25);
}
</script>

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
