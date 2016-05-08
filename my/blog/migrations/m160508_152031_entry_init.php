<?php

use yii\db\Migration;

class m160508_152031_entry_init extends Migration
{
    protected  $tableName = 'entry' ;

    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        /*
        $this->createTable($authManager->ruleTable, [
            'name' => $this->string(64)->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
        ], $tableOptions);
        */
        $tableName = $this->tableName ;
        $this->createTable($tableName, [
            'id'=>  $this->primaryKey(),
            'title'=> $this->string(100),
            'slug'=>$this->string(100)->unique(),
            'body'=>$this->text(),
            // 保持和 TimestampBehavior 一致
            'created_at'=>$this->integer()->notNull(),
            'updated_at'=>$this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        echo "m160508_152031_entry_init cannot be reverted.\n";

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
