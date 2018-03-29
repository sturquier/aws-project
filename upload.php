<?php

include 'app/vendor/autoload.php';
include './credentials.php';

$fileName 	= $_FILES['fileToUpload']['name'];
$file 		= $_FILES['fileToUpload']['tmp_name'];
$fp 		= fopen($file, 'r');
$img 		= fread($fp, filesize($file));
fclose($fp);


// Instantiate an Amazon S3 Client
$s3 = new Aws\S3\S3Client([
	'version'		=> 'latest',
	'region'		=> 'eu-west-3',
	'credentials'	=> getCredentials(),
	'http'			=> [
		'verify' => false
	]
]);

// Upload file to S3 bucket
try {
	$s3->putObject([
		'Bucket'	=> getBucket(),
		'Key'		=> $fileName,
		'Body'		=> $img,
		'ACL'		=> 'public-read',
	]);
} catch (Aws\S3\Exception\S3Exception $e) {
	echo $e->getMessage();
}

// Get object from S3 bucket
try {
	$s3Object = $s3->getObject([
		'Bucket'	=> getBucket(),
		'Key'		=> $fileName,
	]);
} catch (Aws\S3\Exception\S3Exception $e) {
	echo $e->getMessage();
}

// Process recognition
$recognition = new Aws\Rekognition\RekognitionClient([
	'region'		=> 'eu-west-1',
	'version'		=> 'latest',
	'credentials'	=> getCredentials(),
	'http'			=> [
		'verify' => false
	]
]);

$s3File = file_get_contents($s3Object->toArray()['@metadata']['effectiveUri']);

try {
	$recognizedImg = $recognition->detectLabels([
		'Image' => [
			'Bytes'		=> $s3File,
		],
		'MaxLabels'			=> 5,
		'MinConfidence'		=> 80.0,
	]);
} catch (Aws\S3\Exception\S3Exception $e) {
	echo $e->getMessage();	
}


if (file_exists('labels.txt')) {
	unlink('labels.txt');
}

$labelsFile = fopen('labels.txt', 'a+');

foreach ($recognizedImg->toArray()['Labels'] as $label) {
	fwrite($labelsFile, '<li>' . $label['Name'] . '</li>' . "\n");
}

fclose($labelsFile);

header('Location: ' . $_SERVER['HTTP_REFERER']);