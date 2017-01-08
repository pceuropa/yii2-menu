<?php
namespace pceuropa\menu;
#Copyright (c) 2017 Rafal Marguzewicz pceuropa.net LTD

use Yii;
use yii\helpers\Json;
use pceuropa\menu\models\Model;

class Menu extends \yii\base\Module {
	public $controllerNamespace = 'pceuropa\menu\controllers';
	public $defaultRoute = 'creator';

public function init(){
		parent::init();	  // custom initialization code goes here
	}
	
public static function NavbarLeft($id){
		$m = Model::findModel($id);
		$m = Json::decode($m->menu);
		return $m['left'];
	}

public static function NavbarRight($id){
		$m = Model::findModel($id);
		$m = Json::decode($m->menu);
		return $m['right'];
	}
}
