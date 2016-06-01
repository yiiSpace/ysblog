<?php
/**
 * User: yiqing
 * Date: 2014/11/15
 * Time: 14:13
 */

namespace common\base;

use Yii;
use yii\base\Controller;
use yii\base\ViewContextInterface;
use yii\helpers\FileHelper;
use yii\widgets\Block;
use yii\widgets\ContentDecorator;
use yii\widgets\FragmentCache;

class View extends \yii\web\View{
    /**
     * Finds the view file based on the given view name.
     * @param string $view the view name or the path alias of the view file. Please refer to [[render()]]
     * on how to specify this parameter.
     * @param object $context the context to be assigned to the view and can later be accessed via [[context]]
     * in the view. If the context implements [[ViewContextInterface]], it may also be used to locate
     * the view file corresponding to a relative view name.
     * @return string the view file path. Note that the file may not exist.
     * @throws InvalidCallException if a relative view name is given while there is no active context to
     * determine the corresponding view file.
     */
    protected function findViewFile($view, $context = null)
    {
        if (strncmp($view, '@', 1) === 0) {
            // e.g. "@app/views/main"
            $file = Yii::getAlias($view);
        } elseif (strncmp($view, '//', 2) === 0) {
            // e.g. "//layouts/main"
            $file = Yii::$app->getViewPath() . DIRECTORY_SEPARATOR . ltrim($view, '/');
        } elseif (strncmp($view, '/', 1) === 0) {
            // e.g. "/site/index"
            if (Yii::$app->controller !== null) {
                $file = Yii::$app->controller->module->getViewPath() . DIRECTORY_SEPARATOR . ltrim($view, '/');
            } else {
                throw new InvalidCallException("Unable to locate view file for view '$view': no active controller.");
            }
        } elseif ($context instanceof ViewContextInterface) {
            //  +  -------------------------------------------------------------------    +
            //                              ##  modified by yiqing
            // 这里进行改造 支持 thmeme 功能
            // 如果继承自 common\base\Widget 类 那么widget本身具备皮肤功能 这个是推荐用法
            // todo 这里逻辑有点 脏
            if($context instanceof Widget || $context instanceof Controller){
                $file = $context->getViewPath() . DIRECTORY_SEPARATOR . $view;
            }else{
                // TODO 此逻辑 只在特定条件被复写 重复出现只是(ˇˍˇ) 想增加一点点效率！！
                $file = $context->getViewPath() . DIRECTORY_SEPARATOR . $view;

                //  皮肤目录自动探测
                // FIXME 注意只需要处理widget  如果是控制器 那么是在module层面处理的 这里会连带控制器也处理的
                if ( Yii::$app->view->theme !== null) {

                    $theme = Yii::$app->view->theme;
                    if ($theme instanceof \common\base\Theme) {
                        $themeName = $theme->active;
                        $candidateDir = $context->getViewPath() . DIRECTORY_SEPARATOR . $themeName;
                        if (is_dir($candidateDir)) {
                            $file = $candidateDir . DIRECTORY_SEPARATOR . $view;
                        }else{
                            // 不存在 皮肤文件那么还是采用原先的
                            $file = $context->getViewPath() . DIRECTORY_SEPARATOR . $view;
                        }
                    }

                }
            }
            //  +  -------------------------------------------------------------------    +
        } elseif (($currentViewFile = $this->getViewFile()) !== false) {
            $file = dirname($currentViewFile) . DIRECTORY_SEPARATOR . $view;
        } else {
            throw new InvalidCallException("Unable to resolve view file for view '$view': no active view context.");
        }

        if (pathinfo($file, PATHINFO_EXTENSION) !== '') {
            return $file;
        }
        $path = $file . '.' . $this->defaultExtension;
        if ($this->defaultExtension !== 'php' && !is_file($path)) {
            $path = $file . '.php';
        }

        return $path;
    }
} 