<?php
$date = time();

$folder = "files/";
$name = $folder.'export-'.$date.'.csv';

/*$files = new DirectoryIterator("glob://$folder*.php");glob("*.csv");

for ($i = 0; $i < count($files); $i++) { 
	if (substr($files[i], 7, 10) < $date) {
		unlink($files[i]);
	}
}*/

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".$name."\";" );
header("Content-Transfer-Encoding: binary");
//readfile("../".$name);


if(isset($_POST["str"]) && !empty($_POST["str"])){
	$str = htmlentities($_POST["str"]);
	$tab = explode('|', $str);

	$file = fopen($name, 'w');
	for($i = 0; $i < count($tab); $i++){
		$arr = explode('-', $tab[$i]);
		fputcsv($file, $arr);	
	}

	fclose($file);

	echo $folder.'export-'.$date.'.csv';
}

?>