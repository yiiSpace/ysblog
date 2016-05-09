<?php

use yii\db\Migration;

class m160509_004721_ar_init extends Migration
{
    public $interactive = true ;

    public function up()
    {
        $modelAndQueryNs = [
            'ns' => 'my\blog\common\models',
            'queryNs' => 'my\blog\common\models',
        ];
        \Yii::$app->runAction('gii/model', [
            'interactive' => $this->interactive,
            'tableName' => 'entry',
            'modelClass' => 'Entry',
        ] + $modelAndQueryNs );

        \Yii::$app->runAction('gii/model',
            array_merge([
                'interactive' => $this->interactive,
                'tableName' => 'tag',
                'modelClass' => 'Tag',
            ] ,$modelAndQueryNs)
        );
    }

    public function down()
    {
        $modelFiles = [
           '@my\blog\common\models\Tag.php',
           '@my\blog\common\models\Entry.php' ,
        ] ;
       // TODO 删掉生成的文件
        foreach($modelFiles as $modelFile){
            $modelFile = str_replace('\\','/',$modelFile) ; // 名空间替换为文件路径
            $path = Yii::getAlias($modelFile) ;
            if(is_file($path)){
                unlink($path) ;
                echo "    > deleting file <$path> successful ! ".PHP_EOL;
            }
        }
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
