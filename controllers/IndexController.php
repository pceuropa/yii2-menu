<?php

namespace pceuropa\menu\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use vendor\pceuropa\menu\models\Menus;
use yii\web\NotFoundHttpException;



class IndexController extends Controller
{
	// public $layout = 'post';
	
public function actionIndex()
    {
        $model = new Menus();
		return $this->render('index', ['model' => $model]);
		
    }
	


public function actionCreate() {
	
	$model = new Menus();
    $request = Yii::$app->request;
	
    if ($request->isAjax && $model->load($request->post())) {
		
		if($model->type == 1){$model->url = '#';}
		
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => $model->save()];
    }
	

}

public function actionValidate(){
	
    $m = new Menus();
    $req = Yii::$app->request;

    if ($req->isPost && $m->load($req->post())) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return ActiveForm::validate($m);
    }
}


public function actionUpdate($id)
{
	
	$model = $this->findModel($id);
	$request = Yii::$app->request;
	
	
	 if ($request->isAjax && $model->load($request->post())) {
		
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => $model->save()];
    }
	
    return $this->renderAjax('_formUpdate', ['model' => $model,]);
   
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
        if (($model = Menus::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}