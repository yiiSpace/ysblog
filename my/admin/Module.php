<?php

namespace my\admin;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @todo 此处应该为后台模块定制专门的布局 比如使用比较出名的 adminlite 模板
     *
     * @var string
     */
    public $layout =  'column2' ; // '@app/views/layouts/column2' ;
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'my\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
