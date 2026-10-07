<?php

$file = $_GET[ 'page' ];

$configFileNames = [
	'include.php',
	'file1.php',
	'file2.php',
	'file3.php',
];

if( !in_array( $file, $configFileNames, true ) ) {
	echo 'ERROR: File not found!';
	exit;
}

$file = DVWA_WEB_PAGE_TO_ROOT . 'vulnerabilities/fi/' . $file;

?>
