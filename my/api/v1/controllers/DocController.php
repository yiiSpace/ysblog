<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/3
 * Time: 15:56
 */

namespace my\api\v1\controllers;


use yii\base\Module;
use yii\helpers\Json;
use yii\web\Controller;

class DocController extends Controller
{

    public function actions()
    {
         //  var_dump($this->module) ; die(__METHOD__) ;
          //var_dump(\Yii::$app->getModule('api/v1')) ; die(__METHOD__) ;
          $scanDir = [];
         //  $this->getScanDirList($this->module,$scanDir) ;
          $this->getScanDirList(\Yii::$app->getModule('api/v1'),$scanDir) ;

          array_unshift($scanDir,__DIR__.'/../swagger') ;

        return [
            //文档预览地址,配置好后可以直接访问:http://api.yourhost.com/site/doc
            'category' => [
                'class' => 'light\swagger\SwaggerAction',

                'restUrl' => \yii\helpers\Url::to(['api'], true),
            ],
            //看到上面配置的*restUrl*了么，没错, 它就是指向这个地址
            'api' => [
                'class' => 'light\swagger\SwaggerApiAction',
                //这里配置需要扫描的目录,不支持yii的alias,所以需要这里直接获取到真实地址
                'scanDir' => $scanDir /* [
                    $scanDir,

                    Yii::getAlias('@api/modules/v1/swagger'),
                    Yii::getAlias('@api/modules/v1/controllers'),
                    Yii::getAlias('@api/modules/v1/models'),
                    Yii::getAlias('@api/models'),

                ]*/ ,
                //这个下面讲
                'api_key' => 'yiqing',
            ],
        ];
    }

    protected function getScanDirList(Module $module, &$dirList=[])
    {
        $module = $module ;

        $dirList[] = $module->getControllerPath() ;


        $subModules = $module->getModules() ;

        foreach($subModules as $id => $subModuleConf){
            if(is_string($id)){
                $subModule = $module->getModule($id) ;
            }
            $this->getScanDirList($subModule,$dirList) ;
        }


    }

}