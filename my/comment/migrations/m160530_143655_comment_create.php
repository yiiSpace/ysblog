<?php

use yii\db\Migration;

class m160530_143655_comment_create extends Migration
{

    public $tableName = '{{%comment}}';
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName,[
           'id'=> $this->primaryKey(),
            'user_name'=>$this->string(64)->notNull(),
            'email'=>$this->string(64),
            'url'=>$this->string(250),
            'ip'=>$this->string(64),
            'body'=>$this->text() ->notNull(),
            'status'=>$this->smallInteger(),
            'created_at'=>$this->dateTime(),
            'entity_id'=>$this->integer() ->notNull(),
        ]);
    }

    public function safeDown()
    {
    }
}
