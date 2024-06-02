<?php 

include('wp-includes/version.php');
echo "Sinu WordPressi versioon: " . $wp_version . "<br>";

$filename = "wordpress-".$wp_version.".zip";
$url = "https://wordpress.org/wordpress-".$wp_version.".zip";

exec('wget '.$url);
if(!is_dir('wp-reinstaller')) {
	mkdir('wp-reinstaller');
}


$zip_obj = new ZipArchive;
$zip_obj->open($filename);
$zip_obj->extractTo('wp-reinstaller');





move_folder('wp-includes');
move_folder('wp-admin');
deleteDirectory('./wp-reinstaller');



function move_folder($folder_name) {
	$target_file = "./wp-reinstaller/wordpress/".$folder_name;
	$destination_file = "./".$folder_name;
	deleteDirectory($destination_file);
	rename($target_file, $destination_file);
	echo $folder_name." on üle kirjutatud<br>";
}

function deleteDirectory($dirPath) {
   if (is_dir($dirPath)) {
      $files = scandir($dirPath);
      foreach ($files as $file) {
         if ($file !== '.' && $file !== '..') {
            $filePath = $dirPath . '/' . $file;
            if (is_dir($filePath)) {
               deleteDirectory($filePath);
            } else {
               unlink($filePath);
            }
         }
      }
      rmdir($dirPath);
   }
}