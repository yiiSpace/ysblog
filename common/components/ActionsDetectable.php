<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/4/25
 * Time: 9:00
 */

namespace common\components;

use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;
use \yii\base\Controller;

/**
 * Class ActionsDetectable
 * @package common\components
 */
trait ActionsDetectable
{

    /**
     * return all available actions for current module or controller
     *
     * @return array
     * @throws InvalidConfigException
     */
    public function detectActions()
    {
        if ($this instanceof \yii\base\Controller) {
            return static::detectActions4Controller($this);
        } elseif ($this instanceof Module) {
            return static::detectActions4Module($this);
        } else {
            throw new InvalidConfigException(__TRAIT__ . ' can only be used for Controller or Module , but your class is ' . get_class($this));
        }
    }

    public static function detectActions4Controller(Controller $controller)
    {
        //  $availableActions = $this->controller->actions();
        $availableActions = [];
        $rc = new \ReflectionClass($controller);
        foreach ($rc->getMethods() as $reflectionMethod) {
            if ($reflectionMethod->isPublic()) {
                $controllerMethodName = $reflectionMethod->name;
                if (($controllerMethodName !== 'actions') && \yii\helpers\StringHelper::startsWith($reflectionMethod->name, 'action')) {
                    $availableActions[] = substr($controllerMethodName, strlen('action'));
                }
            }
        }
        array_walk($availableActions, function (&$item1, $key) {
            $item1 = \yii\helpers\Inflector::camel2id($item1);
        });
        $availableActions = \yii\helpers\ArrayHelper::merge(
            $availableActions,
            array_keys($controller->actions())
        );

        $actionMenus = [];
        $controllerId = $controller->getUniqueId();
        foreach ($availableActions as $actionId) {
            $actionRoute = $controllerId . '/' . $actionId;
            // $content[] =  \yii\helpers\Html::a($actionRoute,['/'.$actionRoute]) ;
            $actionMenus[] = [
                'label' => $actionRoute,
                'url' => ['/' . $actionRoute],
            ];
        }

        return $actionMenus;
    }

    protected static  function collectControllerPaths()
    {

    }

    public static function detectActions4Module(Module $module)
    {
        $moduleControllerPath = $module->getControllerPath();
        $controllerFileNames = [];
        // @see http://www.ruanyifeng.com/blog/2008/07/php_spl_notes.html
        // @see http://php.net/manual/en/class.directoryiterator.php
        try {
            // 这里写的东西是否诡异 注意 “&” 的使用 而且先要声明该变量 不然use 时 会报错！
            $collectControllerPaths = null;
            $collectControllerPaths = function ($moduleControllerPath, &$controllerFileNames, $parentDir = [])
            use (&$collectControllerPaths) {
               //   echo 'yes' ;    print_r($parentDir) ;
                // TODO 这里改为递归 可以处理目录嵌套情形
                /*** class create new DirectoryIterator Object ***/
                foreach (new \DirectoryIterator($moduleControllerPath) as $item) {
                    /** @var \SplFileInfo $file */
                    $file = $item;
                    //  echo $parentDir,'|', $item . '<br />';
                    // VarDumper::dump($item) ;
                    if (!$file->isDot()) {

                        // 如果还有子目录
                        if ($file->isDir()) {

                             $parentDir[] = $file->getFilename();
                            // array_push($parentDir, $file->getFilename());
                            // echo 'dirName: ' , $file->getFilename() ,'<br/>';
                            // __FUNCTION__
                            call_user_func($collectControllerPaths,
                                $moduleControllerPath . DIRECTORY_SEPARATOR . $file->getFilename(),
                                $controllerFileNames,
                                $parentDir // 累积效应
                            );


                        } else {

                            if (empty($parentDir)) {
                                $controllerFileNames[] = $file->getBasename('Controller.php');
                                // echo $file->getBasename('Controller.php') ;
                            } elseif (count($parentDir)>0) {
                                print_r($parentDir) ;
                                /*
                                // 特殊类型表示 嵌套控制器目录情形
                                array_push($parentDir, $file->getBasename('Controller.php'));
                                $controllerFileName = $parentDir;
                                // print_r($controllerFileName) ;
                                $controllerFileNames[] = $controllerFileName;
                                // print_r($controllerFileNames) ;
                                */
                            }
                        }
                        // echo __FUNCTION__ ;
                        // var_dump($collectControllerPaths) ;
                    }

                }
            };
            $collectControllerPaths($moduleControllerPath, $controllerFileNames);

        } /*** if an exception is thrown, catch it here ***/
        catch (\Exception $e) {
            // echo 'No files Found!<br />';
        }
        print_r($controllerFileNames);
        die(__LINE__);
        if (!empty($controllerFileNames)) {

            $actions4controllers = array_map(function ($item) use ($module) {
                if (is_array($item)) {
                    // print_r($item) ;
                    // die(__METHOD__) ;
                    // 嵌套情形
                    $controllerId = '';
                    // 去掉最首的空字符串元素
                    $parts = array_filter($item);
                    $parts = array_map(function ($item) {
                        return Inflector::camel2id($item);
                    }, $parts);
                    $controllerId = implode('/', $parts);
                } else {
                    $controllerId = Inflector::camel2id($item);
                }

                // echo $controllerId ; exit(__FILE__) ;
                $controller = $module->createControllerByID($controllerId);
                if (!empty($controller)) {
                    return static::detectActions4Controller($controller);
                } else {
                    // TODO  这里有特殊情况哦 比如控制器目录中 有子目录 然后控制器位于其下
                    return [];
                }

            }, $controllerFileNames);

            // reduce  就和卷珠帘 类似 或者 收缩屏风 类似 动作有累积效应
            // @see http://stackoverflow.com/questions/1319903/how-to-flatten-a-multidimensional-array
            return array_reduce($actions4controllers, 'array_merge', array());
        }

        return [];
    }
}