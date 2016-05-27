<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/22
 * Time: 5:08
 */

namespace common\helpers\console;

/**
 * borrow from << skeeks cms >>
 *
 * Class ControllerEnhance
 * @package common\helpers\console
 */
trait ControllerEnhance
{
    /**
     * @return $this
     */
    public function startTool()
    {
        $this->stdoutN('Yii2 (' . \Yii::getVersion() . ')');
       //  $this->stdoutN(\Yii::$app->cms->moduleCms()->getDescriptor()->toString());
        $this->stdoutN('App:' . \Yii::$app->id);
        $this->hr();
        return $this;
    }

    /**
     * @return $this
     */
    public function hr()
    {
        $this->stdoutN('-----------------------------');
        return $this;
    }

    /**
     * @param $text
     * @return $this
     */
    public function stdoutN($text = '')
    {
        $this->stdout("{$text}" . PHP_EOL);
        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function stdoutBlock($text = '')
    {
        $this->stdoutN('');
        $this->stdout(" ****** {$text} *****" . PHP_EOL);
        $this->stdoutN('');
        return $this;
    }

    /**
     * @param $cmd
     */
    public function systemCmd($cmd)
    {
        die('not implemented !') ;

        $this->stdoutN(' - system cmd: ' . $cmd);
        echo \Yii::$app->console->execute($cmd);
    }

    /**
     * @param $cmd
     */
    public function systemCmdRoot($cmd)
    {
        $this->stdoutN(' - system cmd: ' . $cmd);
        //echo \Yii::$app->console->execute("cd " . ROOT_DIR. "; " . $cmd);
        system("cd " . ROOT_DIR. "; " . $cmd);
    }
}