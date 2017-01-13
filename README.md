[![Latest Stable Version](https://poser.pugx.org/pceuropa/yii2-menu/v/stable)](https://packagist.org/packages/pceuropa/yii2-menu) [![Total Downloads](https://poser.pugx.org/pceuropa/yii2-menu/downloads)](https://packagist.org/packages/pceuropa/yii2-menu) [![Latest Unstable Version](https://poser.pugx.org/pceuropa/yii2-menu/v/unstable)](https://packagist.org/packages/pceuropa/yii2-menu) [![License](https://poser.pugx.org/pceuropa/yii2-menu/license)](https://packagist.org/packages/pceuropa/yii2-menu)

Bootstrap Menu Builder for Yii2
============================


![preview](http://pceuropa.net/images/yii2-menu.png)

[DEMO](https://pceuropa.net/menu/creator)

## Features

 * Creating links, drop menus, line (diver) in the navbar-left and/or navbar-right
 * Sorting, editing, and deleting using drag and drop
 * No jQuery for drag and drop ([RubaXa/Sortable](https://github.com/RubaXa/Sortable))
 * CRUD operations by jQuery Ajax)
 
## Installation
```
composer require pceuropa/yii2-menu "2.0.7"
```

Add the following code to config file Yii2
```php
'modules' => [
	'menu' => [
            'class' => '\pceuropa\menu\Menu',
        ],
	]
```

## Configuration

### 1. Create database schema

Make sure that you have properly configured `db` application component and run the following command:

```bash
$ php yii migrate/up --migrationPath=@vendor/pceuropa/yii2-menu/migrations

```


### 2. Add the following code to config file Yii2
```php

use pceuropa\menu\Menu;

NavBar::begin(['brandLabel' => 'Brand','brandUrl' => Url::home(),]);

echo Nav::widget([ 'options' => ['class' => 'navbar-nav navbar-left'],
					'items' => Menu::NavbarLeft(1)  // argument is id of menu
				]);	
					
echo Nav::widget([ 'options' => ['class' => 'navbar-nav navbar-right'],
					'items' => Menu::NavbarRight(1)
				]);
NavBar::end();

```
### 3. Getting started
/menu/creator

