<?php 
namespace pceuropa\menu\models;

#Copyright (c) 2017 Rafal Marguzewicz pceuropa.net LTD

use Yii;
class Model extends \yii\db\ActiveRecord {

	public static function tableName() { 
		return 'menu';
	}


	public function rules(){
		return [
			[['menu_id'], 'integer'],
			[['menu'], 'string'],
		];
	}

	public function attributeLabels(){
		return [
			'menu_id' => Yii::t('app', 'Id'),
			'menu' => Yii::t('app', 'Menu'),
		];
	}
	public static function findModel($id){
	    if (($model = Model::find()->where(['menu_id' => $id])->one()) !== null) {
	        return $model;
	    } else {
	        return (object) [
					'menu' => '{"left" : [{"label": "wrong id of menu"}], "right": []}',
				  ];
	    }
	}
}
