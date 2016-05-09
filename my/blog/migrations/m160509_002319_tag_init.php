<?php

use yii\db\Migration;

class m160509_002319_tag_init extends Migration
{
    public $tableName = 'tag';

    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $tableName = $this->tableName ;
        $this->createTable($tableName, [
            'id'=>  $this->primaryKey(),
            'title'=> $this->string(64),
            'slug'=>$this->string(64)->unique(),

        ]);
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
