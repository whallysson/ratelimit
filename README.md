# Ratelimit @Codeblog 

[![Maintainer](http://img.shields.io/badge/maintainer-@whallysson-blue.svg?style=flat-square)](https://twitter.com/whallysson)
[![Source Code](http://img.shields.io/badge/source-codeblog/ratelimit-blue.svg?style=flat-square)](https://github.com/whallysson/ratelimit)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/codeblog/ratelimit.svg?style=flat-square)](https://packagist.org/packages/codeblog/ratelimit)
[![Latest Version](https://img.shields.io/github/release/whallysson/ratelimit.svg?style=flat-square)](https://github.com/whallysson/ratelimit/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/whallysson/ratelimit.svg?style=flat-square)](https://scrutinizer-ci.com/g/whallysson/ratelimit)
[![Quality Score](https://img.shields.io/scrutinizer/g/whallysson/ratelimit.svg?style=flat-square)](https://scrutinizer-ci.com/g/whallysson/ratelimit)
[![Total Downloads](https://img.shields.io/packagist/dt/codeblog/ratelimit.svg?style=flat-square)](https://packagist.org/packages/codeblog/ratelimit)

###### With the diversification of devices and platforms (mobile, wearable, sites, etc.) the data of our applications, business rules and actions are being exposed using HTTP APIs. A very common need in this scenario is to control the use of these APIs, such as the maximum number of requests that a client can perform in a given time range (rate limit). Ratelimit checks the number of requests made in the header.

Com a diversificação de devices e plataformas (mobile, wearable, sites, etc) os dados de nossas aplicações, regras de negocio e ações estão sendo expostos utilizando API’s HTTP.
Uma necessidade bastante comum neste cenário é de controle do uso destas APIs, como por exemplo o numero máximo de requests que um cliente pode realizar em um determinado range de tempo (rate limit).
O Ratelimit verifica o número de solicitações feitas no cabeçalho.


### Highlights

- Limitation of requests to REST API; (Limitação de requests para REST API)
- Keeps security by checking for remaining requests, preventing overuse; (Mantém a segurança com a verificação de requests restantes, impedindo o uso excessivo)
- Valid every request through HTTP requests; (Válida cada solicitação por meio de HTTP requests)

## Installation

Ratelimit is available via Composer:

```bash
"codeblog/ratelimit": "^1.0"
```

or run

```bash
composer require codeblog/ratelimit
```

## Documentation

#### HTTP Headers and Response Codes

###### Use the HTTP headers in order to understand where the application is at for a given rate limit, on the method that was just utilized.
###### Note that the HTTP headers are contextual. When using app-only auth, they indicate the rate limit for the application context. When using user-based auth, they indicate the rate limit for that user-application context.
* **x-rate-limit-limit:** maximum limit of requests for the application or method;
* **x-rate-limit-remaining:** number of requests, remaining requests;
* **x-rate-limit-reset:** x-rate-limit-reset: remaining time before the rate limit is reset;


##### Cabeçalhos HTTP e códigos de resposta

Use os cabeçalhos HTTP para entender onde o aplicativo está em um determinado limite de taxa, no método que acabou de ser utilizado.

Observe que os cabeçalhos HTTP são contextuais. Ao usar a autenticação somente de aplicativo, eles indicam o limite de taxa para o contexto do aplicativo. Ao usar a autenticação baseada no usuário, eles indicam o limite de taxa para esse contexto de aplicativo do usuário.

* **x-rate-limit-limit:** limite maximo de requests para a aplicação ou método;
* **x-rate-limit-remaining:** o número de pedidos, requests restantes;
* **x-rate-limit-reset:** tempo restante antes que o limite de taxa seja redefinido;


###### For details on how to use, see a sample folder in the component directory. In it you will have an example of use for each class. It works like this:

Para mais detalhes sobre como usar, veja uma pasta de exemplo no diretório do componente. Nela terá um exemplo de uso para cada classe. Ele funciona assim:

#### Usage example

```php
<?php

// Initialise your autoloader (this example is using Composer)
require 'vendor/autoload.php';

use CodeBlog\RateLimit\RateLimit;

$key = 'user-id-999';
$limit = new RateLimit('cache-folder/', $key, 15, 60);

var_dump($limit);
```


## Contributing

Please see [CONTRIBUTING](https://github.com/whallysson/ratelimit/blob/master/CONTRIBUTING.md) for details.

## Support

###### Security: If you discover any security related issues, please email whallyssonallain@gmail.com instead of using the issue tracker.

Se você descobrir algum problema relacionado à segurança, envie um e-mail para whallyssonallain@gmail.com em vez de usar o rastreador de problemas.

Thank you

## Credits

- [Whallysson Avelino](https://github.com/whallysson) (Developer)
- [CodBlog](https://github.com/whallysson) (Team)
- [All Contributors](https://github.com/whallysson/ratelimit/contributors) (This Rock)

## License

The MIT License (MIT). Please see [License File](https://github.com/whallysson/ratelimit/blob/master/LICENSE) for more information.
