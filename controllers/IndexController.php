<?php namespace pceuropa\menu\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use yii\web\NotFoundHttpException;
use pceuropa\menu\models\Model;

class IndexController extends Controller
{
	// public $layout = 'post';
	
public function actionIndex()
{
	$m = new Model();
	return $this->render('index', ['model' => $m]);
	
}

public function actionCreate() {
	
	$m = new Model();
    $request = Yii::$app->request;
	
    if ($request->isAjax && $m->load($request->post())) {
		
		if($m->type == 1){$m->url = '#dropmenu';}
		if($m->type == 2){$m->name = '-------';}
		
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => $m->save()];
    }
}

public function actionValidate(){
	
    $m = new Model();
    $req = Yii::$app->request;

    if ($req->isPost && $m->load($req->post())) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($m);
    }
}


public function actionUpdate($id)
{
	$m = $this->findModel($id);
	$request = Yii::$app->request;
	
	 if ($request->isAjax && $m->load($request->post())) {
		
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => $m->save()];
    }
	
    return $this->renderAjax('_formUpdate', ['model' => $m,]);
}


public function actionDelete()
{
	$r = Yii::$app->request;
	$id = $r->post('id');
	
	\Yii::$app->response->format = Response::FORMAT_JSON;
	return ['success' => $this->findModel($id)->delete()];
}

protected function findModel($id)
{
	if (($m = Model::findOne($id)) !== null) {
		return $m;
	} else {
		throw new NotFoundHttpException('The requested page does not exist.');
	}
}

}
