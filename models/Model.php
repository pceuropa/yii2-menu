<?php 
namespace pceuropa\menu\models;

use Yii;
class Model extends \yii\db\ActiveRecord {

	public static function tableName() { 
		return 'menu';
	}


	public function rules(){
		return [
			[['id'], 'integer'],
			[['menu'], 'string'],
		];
	}

	public function attributeLabels(){
		return [
			'id' => Yii::t('app', 'Id'),
			'menu' => Yii::t('app', 'Menu'),
		];
	}
}
