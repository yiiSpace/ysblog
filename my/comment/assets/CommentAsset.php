<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/31
 * Time: 9:09
 */

namespace my\comment\assets;


use yii\web\AssetBundle;

/**
 * Class CommentAsset
 * @package my\comment\assets
 */
class CommentAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = __DIR__.'/static';

    /**
     * @var array
     */
    public $js = [
        'comments.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}