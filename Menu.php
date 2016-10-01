<?php
namespace pceuropa\menu;

use Yii;
use yii\helpers\ArrayHelper;
use pceuropa\menu\models\Model;

class Menu extends \yii\base\Module {
	public $controllerNamespace = 'pceuropa\menu\controllers';
	public $defaultRoute = 'creator';

public function init(){
		parent::init();	  // custom initialization code goes here
	}
	
public static function NavbarLeft($id){
		$m = self::findModel($id);
		$m = json_decode($m->menu);
		return ArrayHelper::toArray($m->left);
	}

public static function NavbarRight($id){
		$m = self::findModel($id);
		$m = json_decode($m->menu);
		return ArrayHelper::toArray($m->right);
	}
	
protected function findModel($id){

	    if (($model = Model::findOne($id)) !== null) {
	        return $model;
	    } else {
	        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	    }
	}
}
