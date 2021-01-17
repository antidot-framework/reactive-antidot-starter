Reactive Antidot Framework
=================

[![link-packagist](https://img.shields.io/packagist/v/antidot-fw/reactive-starter.svg?style=flat-square)](https://packagist.org/packages/antidot-fw/reactive-starter)

This framework is based on concepts and components of other open source software, especially 
[Zend Expressive](https://docs.zendframework.com/zend-expressive/), 
[Zend Stratigillity](https://docs.zendframework.com/zend-stratigility/), 
[Recoil](https://github.com/recoilphp/recoil) and [React PHP](https://reactphp.org/).

## Installation

Install a project using [composer](https://getcomposer.org/download/) package manager:

````bash
composer create-project antidot-fw/reactive-starter dev
mv dev/.* dev/* ./ && rmdir dev
php public/index.php
````

Open your browser on port `8080`

## Config

### Server Config

Default config

```yaml
parameters:
    server:
      host: '0.0.0.0'
      port: '8080'
      max_concurrency: 100
      buffer_size: 4194304

```

### Development Mode

To run it in dev mode you can run `config:development-mode` command

````bash
bin/console config:development-mode
````

Or you can do it by hand renaming from `config/services/dependencies.dev.yaml.dist` to `config/services/dependencies.dev.yaml`

````bash
mv config/services/dependencies.dev.yaml.dist config/services/dependencies.dev.yaml
````

### Hot Code Reloading

```bash
composer require seregazhuk/php-watcher --dev
```

You can use [Php whatcher](https://github.com/seregazhuk/php-watcher) with composer for more friendly development.

````bash
composer watch
````

![Default homepage](https://getting-started.antidotfw.io/images/default-homepage.jpg)

Open another console and check the built-in Cli tool

````bash
bin/console
````

![Default console tool](https://getting-started.antidotfw.io/images/default-console.jpg)

## Async Usage

It allows executing promises inside PSR-15 and PSR-7 Middlewares and request handlers

### PSR-15 Middleware

```php
<?php
declare(strict_types = 1);

namespace App;

use Antidot\React\PromiseResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SomeMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return new PromiseResponse(
            resolve($request)->then(static fn(ServerrequestInsterface $request) => $handler->handle($request))
        );
    }
}
```

### PSR-7 Request Handler

```php
<?php
declare(strict_types = 1);

namespace App;

use Antidot\React\PromiseResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SomeMiddleware implements RequestHandlerInterface
{
    public function process(ServerRequestInterface $request): ResponseInterface
    {
        return resolve($request)->then(
            function(ServerrequestInterface $request): ResponseInterface {
                return new Response('Hello World!!!');
            }
        );;
    }
}
```

## Classic Usage

It allows executing classic PSR-15 middleware and request handler:

### PSR-15 Middleware

```php
<?php
declare(strict_types = 1);

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SomeMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request);
    }
}
```

### PSR-7 Request Handler

```php
<?php
declare(strict_types = 1);

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SomeMiddleware implements RequestHandlerInterface
{
    public function process(ServerRequestInterface $request): ResponseInterface
    {
        return new Response('Hello World!!!');
    }
}
```

## Benchmark

Using apache ab:

```bash
> ab -n 40000 -c 64 http://127.0.0.1:8080/ 
This is ApacheBench, Version 2.3 <$Revision: 1843412 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking 127.0.0.1 (be patient)

Server Software:        ReactPHP/1
Server Hostname:        127.0.0.1
Server Port:            8080

Document Path:          /
Document Length:        96 bytes

Concurrency Level:      64
Time taken for tests:   16.201 seconds
Complete requests:      40000
Failed requests:        0
Total transferred:      8960000 bytes
HTML transferred:       3840000 bytes
Requests per second:    2468.93 [#/sec] (mean)
Time per request:       25.922 [ms] (mean)
Time per request:       0.405 [ms] (mean, across all concurrent requests)
Transfer rate:          540.08 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.0      0       1
Processing:    15   26   1.4     25      33
Waiting:       15   26   1.4     25      33
Total:         16   26   1.4     25      33

Percentage of the requests served within a certain time (ms)
  50%     25
  66%     25
  75%     26
  80%     26
  90%     27
  95%     29
  98%     31
  99%     32
 100%     33 (longest request)

```

using wrk:

```bash
> wrk -t8 -c64 -d15s http://127.0.0.1:8080/                                                                                                                                                                                                         [95ba8e6]
Running 15s test @ http://127.0.0.1:8080/
  8 threads and 64 connections
  Thread Stats   Avg      Stdev     Max   +/- Stdev
    Latency    26.14ms    1.44ms  34.63ms   92.76%
    Req/Sec   306.84     24.52   373.00     81.17%
  36670 requests in 15.04s, 8.50MB read
Requests/sec:   2437.45
Transfer/sec:    578.42KB
```
