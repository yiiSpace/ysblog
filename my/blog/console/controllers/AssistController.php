<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/29
 * Time: 15:47
 */

namespace my\blog\console\controllers;


use my\blog\common\models\Entry;
use my\user\models\User;
use yii\console\Controller;

class AssistController  extends Controller
{

    /**
     * fill the null field user_id
     */
    public function actionFillUserId()
    {
        Entry::updateAll([
            // 随便找一个id
           'user_id'=> 1, // User::findOne([])->id,
        ]);
    }

}