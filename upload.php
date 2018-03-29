<?php

include 'app/vendor/autoload.php';
include './credentials.php';

$fileName = $_FILES['fileToUpload']['name'];

// Instantiate an Amazon S3 Client
$s3 = new Aws\S3\S3Client([
	'version'		=> 'latest',
	'region'		=> 'eu-west-3',
	'credentials'	=> getCredentials(),
	'http'			=> [
		// 'verify' => 'C:/Users/Turqu/Desktop/turquiersimon.pem'
		'verify' => false
	]
]);

// Upload file to S3 bucket
try {
	$s3->putObject([
		'Bucket'	=> getBucket(),
		'Key'		=> $fileName,
		'Body'		=> $_FILES['fileToUpload']['tmp_name'],
		'ACL'		=> 'public-read',
	]);
} catch (Aws\S3\Exception\S3Exception $e) {
	echo $e->getMessage();
}

// Get file from S3 bucket
try {
	$s3File = $s3->getObject([
		'Bucket'	=> getBucket(),
		'Key'		=> $fileName,
	]);
} catch (Aws\S3\Exception\S3Exception $e) {
	echo $e->getMessage();
}

echo '<pre>';
print_r($s3File);
echo '<pre>';