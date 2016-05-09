<?php

use yii\db\Migration;

class m160509_003118_entry_tag_init extends Migration
{
    public $tableName = 'entry_tag';

    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $tableName = $this->tableName ;
        $this->createTable($tableName, [
            'tag_id'=>  $this->integer(),
            'entry_id'=> $this->integer(),

        ]);
        $this->addPrimaryKey('pk_entry_tag',$tableName,['tag_id','entry_id']);
    }

    public function down()
    {
        $this->dropTable($this->tableName) ;
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
