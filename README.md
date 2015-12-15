Personalized bootstrap menu for Yii2
============================

[![Latest Stable Version](https://poser.pugx.org/pceuropa/yii2-menu/v/stable)](https://packagist.org/packages/pceuropa/yii2-menu) [![Total Downloads](https://poser.pugx.org/pceuropa/yii2-menu/downloads)](https://packagist.org/packages/pceuropa/yii2-menu) [![Latest Unstable Version](https://poser.pugx.org/pceuropa/yii2-menu/v/unstable)](https://packagist.org/packages/pceuropa/yii2-menu) [![License](https://poser.pugx.org/pceuropa/yii2-menu/license)](https://packagist.org/packages/pceuropa/yii2-menu)

## Backend features

 * Creating links and drop menus in the navbar-left and/or navbar-right
 * Sorting, editing, and deleting using drag and drop
 * No jQuery for drag and drop (but there is [support](#jq))
 
## Installation
```
composer require pceuropa/yii2-menu
```

Add the following code to config file Yii2
```php
'modules' => [
	'menu' => [
            'class' => '\pceuropa\menu\Module',
        ],
	]
```