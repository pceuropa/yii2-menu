<?php 
namespace pceuropa\menu;
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net LTD
use yii\web\AssetBundle;

class MenuAsset extends AssetBundle{
    public $sourcePath = '@vendor/pceuropa/yii2-menu/assets';
    public $baseUrl = '@web';
    public $js = [
        'js/Sortable.min.js',
        'js/menu.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
