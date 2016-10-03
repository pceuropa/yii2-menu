<?php

use yii\db\Schema;
use yii\db\Migration;

class m151216_173850_create_menu_table extends Migration
{
    public function up()
    {
		$this->createTable('menu', [
            'menu_id' => $this->primaryKey(),
            'menu' => $this->text()->notNull(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1');
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
