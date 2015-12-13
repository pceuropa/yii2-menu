<?php

namespace pceuropa\menu\models;

use Yii;

class Menus extends \yii\db\ActiveRecord
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

		[['name'], 'required'],
		[['gr', 'serialize', 'type'], 'integer'],
		[['name', 'url', 'menu_0'], 'string', 'max' => 200],
	];
}

/**
* @inheritdoc
*/
public function attributeLabels(){
	return [
		'id_menu' => Yii::t('app', 'Id Menu'),
		'name' => Yii::t('app', 'Name'),
		'url' => Yii::t('app', 'Url'),
		'gr' => Yii::t('app', 'Group'),
	];
}
}
