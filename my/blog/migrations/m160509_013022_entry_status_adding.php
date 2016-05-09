<?php

use yii\db\Migration;

class m160509_013022_entry_status_adding extends Migration
{
    public     $tableName = 'entry' ;
    public function up()
    {


        $this->addColumn($this->tableName,'status',$this->smallInteger()) ;
    }

    public function down()
    {
        //echo "m160509_013022_entry_status_adding cannot be reverted.\n";
        // return false;
        $this->dropColumn($this->tableName,'status') ;
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
