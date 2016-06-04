<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/2
 * Time: 9:35
 */

namespace my\user\helpers;


use my\user\UserAsset;
use yii\helpers\FileHelper;

class Defaults
{

    /**
     * @return string
     */
    public static function getAvatarUrl()
    {
        static $userAsset = null;
        if (empty($userAsset)) {
            $userAsset = UserAsset::register(\Yii::$app->view);
        }
        $assetDir = $userAsset->basePath. DIRECTORY_SEPARATOR . 'default-avatars' ;
        $randAvatarPath = static::getRandomFilePath($assetDir) ;

        $assetBaseUrl = $userAsset->baseUrl ;
        return $assetBaseUrl.'/default-avatars/'.  (basename($randAvatarPath) );
    }

    /**
     *
     * @param string $dir
     * @return mixed
     */
    protected static function  getRandomFilePath($dir='')
    {
        $files = FileHelper::findFiles($dir, ['only' => ['*.jpg','*.gif','*.png']]);
        return $files[array_rand($files)];
    }
}