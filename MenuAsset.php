<?php 
namespace pceuropa\menu;
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net

class MenuAsset extends \yii\web\AssetBundle {
    public $sourcePath = '@vendor/pceuropa/yii2-menu/assets';
    public $baseUrl = '@web';
    public $js = [
        'js/Sortable.min.js',
        'js/menu.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
