Projet AWS
==

Auteurs :
* Pathé Barry
* Sophie Lee
* Simon Turquier

### Description
Le projet permet de :
* Utilisation de `RekognitionClient`
	* Instancier un client AWS `S3Client()`
	* Uploader une image sur le bucket S3 via `putObject()`
	* Puis recuperer l'image via `getObject()`
	* Proceder à la reconnaissance des 5 labels correspondant le mieux à l'image grace au client `RekognitionClient()`
	* Stocker ces labels dans un fichier text via AJAX
	* Afficher ces labels
* Utilisation de `ComprehendClient`
	* Instancier un client Comprehend `ComprehendClient()`
	* Detecter le langage via `detectDominantLanguage()`
	* Detecter les entités via `detectEntities()`
	* Afficher le contenu via AJAX

### Installation
* `git clone https://github.com/sturquier/aws-project/`
* `cd aws-project`
* Creer un fichier credentials.php (voir plus bas)
* `cd app/; composer install`

### Fichier credentials.php

```php
<?php

function getCredentials()
{
	return new Aws\Credentials\Credentials(
		'key', 'secret'
	); 
}

function getBucket()
{
	return 'bucketname';
}
```