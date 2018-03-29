Projet AWS
==

Auteurs :
* Pathé Barry
* Simon Turquier

### Installation
* `git clone https://github.com/sturquier/aws-project/`
* `cd aws-project`
* Creer un fichier credentials.php (voir plus bas)
* `cd app/; composer install`
* `cd ../; php -S localhost:8080`

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