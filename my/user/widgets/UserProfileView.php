<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/5
 * Time: 22:11
 */

namespace my\user\widgets;


use yii\base\Widget;

class UserProfileView extends Widget
{
    /**
     * @var UserProfileView
     */
    protected static $_baseInstance =  null ;

    /**
     * @return UserProfileView
     * @throws \yii\base\InvalidConfigException
     */
    protected static function getBaseInstance()
    {
        if(empty(static::$_baseInstance)){
            static::$_baseInstance = \Yii::createObject(UserProfileView::className()) ;
        }
        return  static::$_baseInstance ;
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function renderProfileHead()
    {
        $absInstance = static::getBaseInstance() ;
        $view = $absInstance->getView() ;
        return $view->render('profile/head',[],$absInstance);
    }


    public function renderBaseBlock($blockId='head',$params=[])
    {
        $absInstance = static::getBaseInstance() ;
        $view = $absInstance->getView() ;
        return $view->render('profile/'.$blockId,$params,$absInstance);
    }

    public function getBaseBlocks()
    {

    }

}