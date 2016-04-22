<?php
namespace pceuropa\menu;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use pceuropa\menu\models\Model;
use yii\bootstrap\Dropdown;

class Module extends \yii\base\Module
{
public $controllerNamespace = 'pceuropa\menu\controllers';
public $defaultRoute = 'index';

const NAV_ID_LEFT = 0;
const NAV_ID_RIGHT = 1;
public $color;

private static $sortOption = ['gr' => SORT_ASC, 'serialize' => SORT_ASC, ];


public function init(){
    
	parent::init();	
        // custom initialization code goes here
}
	
	
public static function NavbarLeft(){

	$m = Model::find()->where("gr != 1")->orderBy(self::$sortOption)->all();
	return self::toArray($m, self::NAV_ID_LEFT);
}

public static function NavbarRight(){

	$m = Model::find()->where("gr != 0")->orderBy(self::$sortOption)->all();
	return self::toArray($m, self::NAV_ID_RIGHT);
}

public static function Link($a){
	return Html::tag('li', Html::a($a['label'], $a['url']), ['id' => $a['id'], 'data-id' => $a['id'], 'data-type' => 'link']);
}

public static function DropMenu($a){
	
	$items = ArrayHelper::getValue($a, 'items') ;
	if ($items == null) {
		$items = [];
	}

	$dropmenu = '<a href="#dropmenu" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$a['label'].'<span class="caret"></span></a>'
    .Dropdown::widget([
            'items' => $items,
			'options' => ['class' => 'dropdown-menu', 'id' => 'ul'.$a['options']['id']]
        ]);
    
	return Html::tag('li', $dropmenu, ['id' => $a['options']['id'],  'data-type' => 'dropmenu']);
	
}

private static function toArray($model, $navbar){
	$a = []; 
	
	foreach ($model as $k => $v){ 
	
		if ($v->gr == $navbar) { // main elements in navbar 
			
			$v->url == "#dropmenu" ? 
				$a[$v->menu_id] = ['label' => $v->name, 'options' => ['id' => $v->menu_id,]] :
				$a[$v->menu_id] = ['label' => $v->name, 'url' => $v->url, 'id' => $v->menu_id];
			
			
		} else { // elements of DropMenus
			
			if (array_key_exists($v->gr, $a)){
				$v->name == '-------' ? 
				$a[$v->gr]['items'][] = '<li id="'.$v->menu_id.'" class="divider">-------</li>' :
				$a[$v->gr]['items'][] = ['label' => $v->name, 'url' => $v->url, 'options' => ['id' => $v->menu_id]];
			}
		}

	}
	return $a;
}



public function whichElementsDrop(){
	$elements = Model::find()->where(['url' => "#dropmenu"])->asArray()->all();
	
	$txt = '';
	foreach ($elements as $v){
		$txt .=	 'Sortable.create(ul'.$v['menu_id'].', config);';
	}
	return $txt;
}


}
