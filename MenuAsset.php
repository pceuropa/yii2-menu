<?php namespace pceuropa\menu;

use yii\web\AssetBundle;

class MenuAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/assets';
    public $baseUrl = '@web';
    public $js = [
        'js/Sortable.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}