Projet AWS
==

Auteurs :
* Pathé Barry
* Simon Turquier

### Description
Le projet permet de :
* Instancier un client AWS `S3Client()`
* Uploader une image sur le bucket S3 via `putObject()`
* Puis recuperer l'image via `getObject()`
* Proceder à la reconnaissance des 5 labels correspondant le mieux à l'image grace au client `RekognitionClient()`
* Stocker ces labels dans un fichier text via AJAX
* Afficher ces labels

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