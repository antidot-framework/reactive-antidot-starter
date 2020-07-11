Reactive Antidot Framework
=================

This framework is based on concepts and components of other open source software, especially 
[Zend Expressive](https://docs.zendframework.com/zend-expressive/), 
[Zend Stratigillity](https://docs.zendframework.com/zend-stratigility/), 
[Recoil](https://github.com/recoilphp/recoil) and [React PHP](https://reactphp.org/).

## Installation

Install a project using [composer](https://getcomposer.org/download/) package manager:

````bash
composer create-project antidot-fw/reactive-starter:dev-master dev
mv dev/.* dev/* ./ && rmdir dev
bin/console react-server:http
````

Open your browser on port `8080`

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
