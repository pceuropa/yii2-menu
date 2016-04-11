<?php namespace pceuropa\menu\models;

use Yii;
use yii\helpers\ArrayHelper;
class Model extends \yii\db\ActiveRecord
{
public $type;
const LINK = 0;
const DROPMENU = 1;

public static function tableName() { return 'menu'; }

public function scenarios()
{
	return [
		'default' => ['url', 'name', 'gr', 'type'],
		'group' => ['url', 'name',]
	];
}

public function rules(){
	return [
		[['gr', 'serialize', 'type'], 'integer'],
		[['name', 'url', 'menu_0'], 'string', 'max' => 200],
	];
}

public function attributeLabels(){
	return [
		'id_menu' => Yii::t('app', 'Id Menu'),
		'name' => Yii::t('app', 'Text'),
		'url' => Yii::t('app', 'Url'),
		'gr' => Yii::t('app', 'Group'),
	];
}

public function ListOfGroup(){
	$array_start = [0 => 'navbar-left', 1 => 'navbar-right'];
	$array_add = ArrayHelper::map(Model::find()->where(["url" => "#dropmenu" ])->all(), 'menu_id', 'name');
	
	return ArrayHelper::merge($array_start, $array_add);
}


}
