<?php

include 'app/vendor/autoload.php';
include './credentials.php';

$textToAnalyze = $_GET['textToAnalyze'];

// Process comprehend
$comprehend = new Aws\Comprehend\ComprehendClient([
	'region'		=> 'eu-west-1',
	'version'		=> 'latest',
	'credentials'	=> getCredentials(),
	'http'			=> [
		'verify' => false
	]
]);

// Detect language
try {
	$dominantLanguageObject = $comprehend->detectDominantLanguage([
		'Text' => $textToAnalyze,
	]); 
} catch (Aws\S3\Exception\S3Exception $e) {
	echo $e->getMessage();
}

$dominantLanguageCode 	= $dominantLanguageObject['Languages'][0]['LanguageCode'];
$dominantLanguageScore 	= $dominantLanguageObject['Languages'][0]['Score'];

echo ' La langue "' . $dominantLanguageCode . '" a été détectée pour un score de ' . $dominantLanguageScore;

// Detect entities
try {
	$detectedEntities = $comprehend->detectEntities([
		'LanguageCode'	=> $dominantLanguageCode,
		'Text' 			=> $textToAnalyze,
	]); 
} catch (Aws\S3\Exception\S3Exception $e) {
	echo $e->getMessage();
}

echo '<table class="table table-striped;">
	<tr>
		<th>Type</th>
		<th>Text</th>
		<th>Score</th>
	</tr>';

foreach ($detectedEntities->toArray()['Entities'] as $entity) {
	echo '<tr>';
		echo '<td>' . $entity['Type'] . '</td>';
		echo '<td>' . $entity['Text'] . '</td>';
		echo '<td>' . $entity['Score']. '</td>';
	echo '</tr>';
}

echo '</table>';