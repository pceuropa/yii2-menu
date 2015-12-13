<?php
namespace pceuropa\menu\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use vendor\pceuropa\menu\models\Menus;
use yii\web\Response;

class SortController extends Controller
{

public function actionIndex(){
		return true;
    }

public function actionSameGroup(){

	$r = Yii::$app->request;
	$id = $r->post('gr');

	$array = Menus::find()->select('menu_id')->where(["gr" => $id[2] ])->orderBy(['serialize' => SORT_ASC, 'menu_id' => SORT_ASC])->asArray()->all();
	$array = ArrayHelper::getColumn($array, 'menu_id');
	
		if ($r->isAjax) {
		$out = array_splice($array, $r->post('oldIndex'), 1);
		array_splice($array, $r->post('newIndex'), 0, $out);
		
		foreach($array as $k => $v){
			$m = Menus::findOne($v);
			$m->serialize = $k;
			if ($m->save()) {$result = true;}
		}
		
		\Yii::$app->response->format = Response::FORMAT_JSON;
		return ['success' => $result];
		
    }
    return false;
}

public function actionNotSameGroup(){

	$r = Yii::$app->request;

    if ($r->isAjax) {
		
	$id = $r->post('id');
	$gr = substr($r->post('gr'), 2);

	$array = Menus::find()->select('menu_id')->where(["gr" => $gr ])->orderBy(['serialize' => SORT_ASC, 'menu_id' => SORT_ASC])->asArray()->all();
	$array = ArrayHelper::getColumn($array, 'menu_id');
	
	array_splice( $array, $r->post('newIndex'), 0, $id );
	
		foreach($array as $k => $v){
			$m = Menus::findOne($v);
			$m->gr = $gr;
			$m->serialize = $k;
			if ($m->save()) {$result = true;}
		}
		
	\Yii::$app->response->format = Response::FORMAT_JSON;
	return ['success' => $result];

}


}
}
?>