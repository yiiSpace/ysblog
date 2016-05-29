<?php

use yii\db\Migration;

class m160529_071734_entry_add_user_id extends Migration
{
   protected function getTableName()
   {
       return \my\blog\common\models\Entry::tableName() ;
   }

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        // NOTE  这里可以控制添加字段的顺序哦！
        $this->addColumn($this->getTableName(),'user_id',$this->integer().' AFTER [[id]]');
        $this->addCommentOnColumn($this->getTableName(),'user_id','author_id refers to User ');
    }

    public function safeDown()
    {
        $this->dropColumn($this->getTableName(), 'user_id') ;
    }
}
