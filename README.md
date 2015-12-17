Bootstrap menu menager for Yii2
============================

[![Latest Stable Version](https://poser.pugx.org/pceuropa/yii2-menu/v/stable)](https://packagist.org/packages/pceuropa/yii2-menu) [![Total Downloads](https://poser.pugx.org/pceuropa/yii2-menu/downloads)](https://packagist.org/packages/pceuropa/yii2-menu) [![Latest Unstable Version](https://poser.pugx.org/pceuropa/yii2-menu/v/unstable)](https://packagist.org/packages/pceuropa/yii2-menu) [![License](https://poser.pugx.org/pceuropa/yii2-menu/license)](https://packagist.org/packages/pceuropa/yii2-menu)
![preview](http://pceuropa.net/imgs/yii2-menu.png)

[DEMO](http://yii2-menu.pceuropa.net/menu)

## Features

 * Creating links, drop menus, line (diver) in the navbar-left and/or navbar-right
 * Sorting, editing, and deleting using drag and drop
 * No jQuery for drag and drop ([RubaXa/Sortable](https://github.com/RubaXa/Sortable))
 * CRUD operations by jQuery Ajax)
 
## Installation
```
composer require pceuropa/yii2-menu dev-master
```

Add the following code to config file Yii2
```php
'modules' => [
	'menu' => [
            'class' => '\pceuropa\menu\Module',
        ],
	]
```

## Configuration

### 1. Create database schema

Make sure that you have properly configured `db` application component
and run the following command:

```bash
$ php yii migrate/up --migrationPath=@vendor/pceuropa/yii2-menu/migrations

```


### 2. Add the following code to config file Yii2
```php

$menu = new pceuropa\menu\Module([]);

NavBar::begin(['brandLabel' => 'Brand','brandUrl' => Url::home(),]);

echo Nav::widget([ 'options' => ['class' => 'navbar-nav navbar-left'],
					'items' => $menu->Left() 
				]);	
					
echo Nav::widget([ 'options' => ['class' => 'navbar-nav navbar-right'],
					'items' => $menu->Right()
				]);
NavBar::end();

```

Author: [@Marguzewicz](https://twitter.com/Marguzewicz) | [Donation](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=patriota%40or7%2eeu&lc=PL&item_name=Rafal%20Marguzewicz&no_note=1&no_shipping=1&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted)