<?php

use yii\db\Schema;
use yii\db\Migration;

class m151216_173850_create_menu_table extends Migration
{
    public function up()
    {
		$this->createTable('menu', [
            'menu_id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'url' => $this->string(255)->notNull(),
			'gr' => $this->integer(2)->defaultValue(0)->notNull(),
			'serialize' => $this->integer()->defaultValue(100),
            
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=2');
    }

    public function down()
    {
        echo "m151216_173850_create_menu_table cannot be reverted.\n";
        return false;
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
