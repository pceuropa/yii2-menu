<?php
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net LTD

namespace pceuropa\menu;
use yii\base\Widget;

class MenuWidget extends Widget{
	public$message;
	public function init(){
        parent::init();
        if ($this->message === null) {
            $this->message = 'Hello World';
        }
    }

    public function run(){
		return $this->render('index');
    }

	public function generator(){
        	
    }


}
