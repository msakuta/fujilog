<?php header("Content-Type:text/plain"); ?>
<?php

$maxsize = 100000;
$updir = "./up/";

do{
	if(0 < count($_POST['dir'])){

		// A very basic way to limit upload destination to the immediate directory.
		if(strchr($_POST['dir'], '/')){
			echo "failed\n";
			echo "path must not include a slash.";
			break;
		}

		$updir = "./" . $_POST['dir'];
		if(!file_exists($updir)){
			mkdir($updir);
		}
		$updir .= "/";
	}

	if($_FILES['fl']['name']==""){
		echo "empty\n";
		break;
	}

	if(file_exists($updir.$_FILES['fl']['name'])==TRUE/* && $_POST['frb']=="true"*/) {
		echo "failed\n";
		echo "file already exists\n";
	}
	elseif($maxsize < $_FILES['fl']['size']){
		echo "failed\n";
		echo "size limit " . $maxsize . " is exceeded: " . $_FILES['fl']['size'];
	}
	elseif(!is_uploaded_file($_FILES['fl']['tmp_name'])) {
		echo "failed\n";
		echo "something's wrong for uploading";
	}
	elseif(!move_uploaded_file($_FILES['fl']['tmp_name'],$updir.$_FILES['fl']['name'])){
		echo "failed\n";
		echo "something's wrong moving uploaded file";
	}
	else{
		echo "succeeded\n";
		echo "size=" . $_FILES['fl']['size'];

		// Save the last image successfully uploaded.
		// This is necessary because the client sometimes fails to upload, making live,php
		// not capable of showing the image.
		$fp = fopen('current', 'w');
		if($fp){
			fwrite($fp, $updir.$_FILES['fl']['name']);
			fclose($fp);
		}

		// Save upload log
		$fp = fopen('upload.log', 'a');
		if($fp){
			fwrite($fp, $updir.$_FILES['fl']['name'] . "\n");
			fclose($fp);
		}
	}
} while(0);
?>
