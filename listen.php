<?php

include 'app/vendor/autoload.php';
include './credentials.php';

$textToListen = $_POST['textToListen'];

// Process polly
$polly = new Aws\Polly\PollyClient([
	'region'		=> 'eu-west-1',
	'version'		=> 'latest',
	'credentials'	=> getCredentials(),
	'http'			=> [
		'verify' => false
	]
]);

try {
	$synthesizedSpeechObject = $polly->synthesizeSpeech([
		'OutputFormat'	=> 'mp3',
		'Text'			=> $textToListen,
		'TextType'		=> 'text',
		'VoiceId'		=> 'Matthew',
	]);
} catch (Aws\S3\Exception\S3Exception $e) {
	echo $e->getMessage();
}

$synthesizedSpeech = $synthesizedSpeechObject->get('AudioStream')->getContents();

if (file_exists('polly.mp3')) {
	unlink('polly.mp3');
}

$pollyFile = fopen('polly.mp3', 'a+');

fwrite($pollyFile, $synthesizedSpeech);
fclose($pollyFile);

header('Location: ' . $_SERVER['HTTP_REFERER']);