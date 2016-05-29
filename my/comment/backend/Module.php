<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/29
 * Time: 0:29
 */

namespace my\comment\backend;


class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'my\comment\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}