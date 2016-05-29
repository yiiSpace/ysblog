<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/29
 * Time: 21:26
 */

namespace my\user\helpers;


class Password
{
    public static function makePassword($plainText)
    {
        \Yii::$app->security->generatePasswordHash($plainText);
    }

    public static function checkPassword($rawPassword,$passwordHash )
    {
        // return $passwordHash === \Yii::$app->security->generatePasswordHash($rawPassword) ;
        return \Yii::$app->security->validatePassword($rawPassword,$passwordHash);
    }
}