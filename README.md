<p align="center">
  <img width="375" height="150" src="https://github.com/phonetworks/commons-php/raw/master/.github/cover-smaller.png">
</p>

# pho-kernel

A simple microkernel implementation with Twitter-like functionality by default. You may change the functionality simply by copy/pasting a new recipe from the [presets](https://github.com/phonetworks/pho-kernel/tree/master/presets) directory. Check out "Working with Custom Recipes" below the README file for more information.

## Requirements

The default pho-kernel requires:

* [Redis server 4.0+](https://redis.io)
* [PHP 7.2+](https://php.net)
* [Composer](https://getcomposer.org/) latest version

You may also test pho-kernel by using [Vagrant](https://www.vagrantup.com/). Check out "Testing" for more information.

Pho-Kernel used to depend on [Neo4j Server 3.1+](https://neo4j.com) for indexing. It no longer does as of version 3.0. But you may still use it if you prefer more advanced Cypher queries. 

> If you will use Neo4J for indexing, make sure you change your .env
> file to include INDEX_TYPE="neo4j" instead of INDEX_TYPE ="redis"

## Testing

Testing allows you to get a feel of pho-kernel without bloating your system with servers such as Redis and Neo4j. However, you would still need to have [Vagrant](https://www.vagrantup.com/) installed.

Once you have Vagrant, just type in the following in the directory where pho-kernel is installed:

```shell
vagrant up
vagrant ssh # this will open a new session, continue from there.
cd /opt/pho-kernel
yes | cp presets/basic ./composer.json
composer install # this may take a while to operate
php -a # this will also open a new session.
include("kernel.php");
```

Now you can play with the kernel. Check out "Getting Started" for more information.

## Install

The recommended way to install pho-kernel is through composer. 

Let's say, you want to install a kernel under a directory called ```test-dir```. Here's what you type in the terminal:

```shell
composer create-project -s "dev" phonetworks/pho-kernel test-dir
```

This will install pho-kernel as well as its dependencies. Once installed, read/edit the bootstrapper script [kernel.php](https://github.com/phonetworks/pho-kernel/blob/master/kernel.php). The sole purpose of the bootstrapper script is 

* to set up the servers (e.g. Neo4J, Redis, loggers etc) given environment envirables set in ```.env``` file.
* provide you with the ```$kernel``` which you can use to interact with your graph, or embed in another environment (e.g. [REST Server](https://github.com/phonetworks/pho-server-rest)) for further functionality.

You will also need to set up a .env file to instruct the kernel about the services to use. A sample .env file is included as ```.env.example```. Just copy/paste it as .env to get started with the basics.

```shell
cp .env.example .env
# vi .env # if necessary
```

## Getting Started

1. Make sure your .env file is functional; addressing your servers properly.
2. Run ```php -a``` on your terminal to switch to PHP shell. Then,

```php
include("kernel.php"); // this will set it up.

echo $founder; // will dump the founder's ID.
echo $graph; // will dump the graph's ID.

$tweet = $founder->post("My first tweet"); // let's create a tweet.

$new_user = new \PhoNetworksAutogenerated\User($kernel, $graph, "my_password"); // let's create our first user object.
$new_user->like($tweet); // the user likes the one and only tweet in the graph.

// Now examine these:
var_dump($tweet->getLikers());
var_dump($tweet->getAuthors());
var_dump($new_user->getLikes());
var_dump($founder->getPosts());
```

## Working with Custom Recipes

If you'd like the kernel to run on a custom recipe, you must:

1. Clone this repository. ```git clone https://github.com/phonetworks/pho-kernel```
2. Change the [composer.json](https://github.com/phonetworks/pho-kernel/tree/master/composer.json) file and replace ```pho-recipes/basic``` with your custom recipe repo.
3. Run ```composer install``` to finish up with dependencies.
4. Follow the steps described in the "Getting Started" section.

The [presets](https://github.com/phonetworks/pho-kernel/tree/master/presets) directory comes with custom composer.json files that you can copy/paste on the existing [one](https://github.com/phonetworks/pho-kernel/tree/master/composer.json). This could enable you to run a Facebook or Twitter clone in a few simple steps.

However, if your goal is to run a completely custom recipe, then first of all, you need to:

1. Form that recipe (possibly by cloning one of the existing ones in the https://github.com/pho-recipes repo).
2. Make your recipe a composer package by uploading it to https://packagist.org
3. Replace ```pho-recipes/basic``` with your custom recipe repo in [composer.json](https://github.com/phonetworks/pho-kernel/tree/master/composer.json)
4. Run ```composer install``` to finish up with dependencies.
5. Follow the steps described in the "Getting Started" section.

## The kernel.php file

If you are running pho-kernel on a custom set of compiled pgql files, make sure:

1. The ```default_objects``` variables in Kernel configs (as shown by ```$configs``` in [kernel.php](https://github.com/phonetworks/pho-kernel/blob/master/kernel.php)) have a proper set of "graph" and "user" classes set.
2. Before booting up the kernel, a custom founder object is initialized and passed as an argument to the ```boot``` method.

## License

MIT, see [LICENSE](https://github.com/phonetworks/pho-kernel/blob/master/LICENSE).
