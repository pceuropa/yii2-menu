<?php 
namespace pceuropa\menu\models;

#Copyright (c) 2017 Rafal Marguzewicz pceuropa.net LTD

use Yii;
class Model extends \yii\db\ActiveRecord {

    public static $availableMenuTypes = [
        'link' => 'Link',
        'dropmenu' => 'Dropdown menu',
        'line' => 'Line (devider)'
    ];

	public static function tableName() { 
		return 'menu';
	}


	public function rules(){
		return [
			[['menu_id'], 'integer'],
            [['menu_name'], 'safe'],
			[['menu'], 'string'],
		];
	}

	public function attributeLabels(){
		return [
			'menu_id' => Yii::t('app', 'Id'),
            'menu_name' => Yii::t('app', 'Menu name'),
			'menu' => Yii::t('app', 'Menu'),
		];
	}
	public static function findModel($id){
        if (is_int($id)) {
            $where = ['menu_id' => $id];
        }
        else {
            $where = ['like', 'lower(menu_name)', $id];
        }

        $model = Model::find()->where($where)->one();

	    if ($model !== null) {
	        return $model;
	    } else {
	        return (object) [
					'menu' => '{"left" : [{"label": "wrong id of menu"}], "right": []}',
				  ];
	    }
	}
}
