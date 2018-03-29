<?php

include 'app/vendor/autoload.php';

// $test = new App\Test();

$s3 = new Aws\S3\S3Client([
	'version'	=> 'latest',
	'region'	=> 'eu-west-1'
]);

var_dump($s3);