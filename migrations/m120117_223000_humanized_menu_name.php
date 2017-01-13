<?php

use yii\db\Schema;
use yii\db\Migration;

class m120117_223000_humanized_menu_name extends Migration
{
    protected $newColumnName = 'menu_name';

    public function up()
    {
        $table = \pceuropa\menu\models\Model::tableName();
        $this->addColumn($table, $this->newColumnName, $this->char('255'));
        $this->createIndex($this->getIndexName(), $table, $this->newColumnName);
    }

    public function down()
    {
        $table = \pceuropa\menu\models\Model::tableName();
        $this->dropIndex($this->getIndexName(), $table);
        $this->dropColumn($table, $this->newColumnName);
    }

    protected function getIndexName()
    {
        $table = \pceuropa\menu\models\Model::tableName();
        return "unique-index-{$table}-{$this->newColumnName}";
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
