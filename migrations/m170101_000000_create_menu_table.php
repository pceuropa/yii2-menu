<?php
#Copyright (c) 2017 Rafal Marguzewicz pceuropa.net
use yii\db\Schema;
use yii\db\Migration;

class m170101_000000_create_menu_table extends Migration
{
	protected $table = 'menu';
	
    public function up(){
    
		$options = null;
        if ($this->db->driverName === 'mysql'){
        
            $options = 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1';
        }
        
	$this->createTable($table, [
            'menu_id' => $this->primaryKey(),
            'menu' => $this->text()->notNull(),
        ], $options);
    }

    public function down(){
    
        $this->dropTable($table);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
