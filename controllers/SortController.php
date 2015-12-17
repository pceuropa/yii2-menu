<?php
namespace pceuropa\menu\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use pceuropa\menu\models\Model;

class SortController extends Controller
{

public function actionIndex(){
		return true;
    }

public function actionSameGroup(){

	$r = Yii::$app->request;
	$gr = substr($r->post('gr'), 2);

	$array = Model::find()->select('menu_id')->where(["gr" => $gr ])->orderBy(['serialize' => SORT_ASC, 'menu_id' => SORT_ASC])->asArray()->all();
	$array = ArrayHelper::getColumn($array, 'menu_id');
	
		if ($r->isAjax) {
		$out = array_splice($array, $r->post('oldIndex'), 1);
		array_splice($array, $r->post('newIndex'), 0, $out);
		
		foreach($array as $k => $v){
			$m = Model::findOne($v);
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

	$array = Model::find()->select('menu_id')->where(["gr" => $gr ])->orderBy(['serialize' => SORT_ASC, 'menu_id' => SORT_ASC])->asArray()->all();
	$array = ArrayHelper::getColumn($array, 'menu_id');
	
	array_splice( $array, $r->post('newIndex'), 0, $id );
	
		foreach($array as $k => $v){
			$m = Model::findOne($v);
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