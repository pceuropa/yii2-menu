<?php 
namespace pceuropa\menu\models;

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
}
