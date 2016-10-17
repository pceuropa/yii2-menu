<?php namespace pceuropa\menu\controllers;

use Yii;
use yii\web\Response;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

use pceuropa\menu\models\Model;
use pceuropa\menu\models\Search;

class CreatorController extends \yii\web\Controller {

	public function beforeAction($action) {
		$this->enableCsrfValidation = false;
		return parent::beforeAction($action);
	}

	public function actionIndex(){

		$searchModel = new Search();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionCreate(){
		$m = new Model();
		$r = Yii::$app->request;
	
		 if ($r->isAjax) {
			$m->menu = $r->post('menu');
			\Yii::$app->response->format = Response::FORMAT_JSON;
			return ['success' => $m->save(), 'url' => Url::to(['index'])];
		} else {
			return $this->render('create');}
	}

	public function actionView($id){
		$m = Model::findModel($id);
		$r = Yii::$app->request;
	
		 if ($r->isAjax) {
			\Yii::$app->response->format = Response::FORMAT_JSON;

			switch (true) {
				case $r->post('get'): return ['success' => true, 'menu' => $m->menu];
				default: return ['success' => false];
			}
		}

		return $this->render('view', ['model' => $m]);
	}

	public function actionUpdate($id){
		$m = Model::findModel($id);
		$r = Yii::$app->request;
	
		 if ($r->isAjax) {
			\Yii::$app->response->format = Response::FORMAT_JSON;

			switch (true) {
				case $r->isGet : return ['success' => true, 'menu' => $m->menu];
				case $r->post('update'): 
					$m->menu = $r->post('menu');
					return $m->save() ? ['success' => true] : ['success' => false]; 
				default: return ['success' => false];
			}
		}
	
		return $this->render('update');
	}

	public function actionDelete($id){
		$this->findMenu($id)->delete();
		return $this->redirect(Yii::$app->request->referrer);
	}


}
