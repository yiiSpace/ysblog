<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/1
 * Time: 16:16
 */

namespace common\ui;


use yii\web\AssetBundle;

/**
 * Class PureAsset
 * @package common\ui
 */
class PureAsset extends AssetBundle
{
    /*
    public $sourcePath = '@bower/';
    public $js = [
        'riot/riot+compiler.min.js'

    */

    public $sourcePath = __DIR__.'/vendor/yahoo/pure-release-0.6.0' ;

    public $css = [
        'pure-min.css',
    ];
}