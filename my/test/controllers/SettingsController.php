<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/8/20
 * Time: 10:29
 */

namespace my\test\controllers;

use Yii ;
use yii\helpers\Json;
use yii\web\Controller;

class SettingsController extends Controller
{

    public function actionIndex()
    {
        $categoryName = 'sys';
        $itemName = 'site_config';
        $itemValue = Json::encode([
           'name'=>'Yii_Blog',
            'icon'=>'yii blog icon',
        ]);
        /*
* Set a database item:
* $itemName can be an associative array() in key=>value pairs  ($itemValue="" in this case)
*/
        Yii::$app->settings->set($categoryName, $itemName, $itemValue, $toDatabase=true);

// Get a database item:
        $itemValue = Yii::$app->settings->get($categoryName, $itemName);
         print_r(
             $itemValue
         );

// Get all items from a category:
      $allItems =   Yii::$app->settings->get($categoryName);
      print_r([
         'all'=>$allItems
      ]);
// Delete a database item:
      //  Yii::$app->settings->delete($categoryName, $itemName);

// Delete all items from a category:
     //   Yii::$app->settings->delete($categoryName);
    }

}