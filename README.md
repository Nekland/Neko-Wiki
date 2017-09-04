Neko Wiki
============

[![Build Status](https://travis-ci.org/Nekland/Neko-Wiki.svg?branch=master)](https://travis-ci.org/Nekland/Neko-Wiki) [![Stories in Ready](https://badge.waffle.io/Nekland/Neko-Wiki.svg?label=ready&title=Ready)](https://waffle.io/Nekland/Neko-Wiki)

For now, nothing serious.

Requirements
------------

- PHP 5.6+ / composer
- MariaDB
- NodeJS/NPM

Installation
------------

```bash
$ composer install
$ app/console doctrine:database:create
$ app/console doctrine:schema:create
$ app/console assetic:dump # Yes, it uses assetic
$ app/console server:run
```


Many thanks to
--------------

* [Nekland team](http://team.nekland.fr) :)
* The guy that made [our flag icons](http://www.icondrawer.com/flag-icons.php)
