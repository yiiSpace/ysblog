<?php
/**
 * User: yiqing
 * Date: 14-9-19
 * Time: 下午2:52
 */

namespace common\components;

use Imagine\Image\Box;
use Imagine\Image\ManipulatorInterface;
use Yii ;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\web\HttpException;

/**
 * 缩略图生成控制器
 * 参考wiki： http://www.yiiframework.com/wiki/419/image-resize-on-the-fly/
 *
 * Class UploadsController
 * @package app\controllers\front
 */
class UploadsController extends \yii\web\Controller{

    /**
     *
     */
    public function actionTestThumb(){
        // 最后面的 _200x300 将被换掉
        //  echo CHtml::image(bu("/public/thumbs/public/images/banner1.jpg_200x300.jpg"));
        echo Ys::thumbUrl('/public/images/banner1.jpg',200);
    }
    public function actionThumbs()
    {
       //print_r(Yii::$app->request->get());
        $imgSrc = Yii::$app->request->get('img-src');

       // echo Url::to([$this->route,'img-src'=>'anySrc.jpg']);
        // $request = str_replace(DIRECTORY_SEPARATOR . 'thumbs', '', Yii::app()->request->requestUri);
        // $resourcesPath = Yii::getPathOfAlias('webroot') . $request;

       //  $request = str_replace('/public/thumbs', '', Yii::app()->request->requestUri);
       // $resourcesPath = Yii::getPathOfAlias('webroot') . substr($request,strlen(bu())) ;
       // $targetPath = Yii::getPathOfAlias('webroot') . substr(Yii::app()->request->requestUri,strlen(bu()));

        $resourcesPath = Yii::getAlias('@webroot') . '/uploads/'.$imgSrc;
        $targetPath = Yii::getAlias('@webroot') . '/uploads/thumbs/'.$imgSrc;

        //die($targetPath);

        if (preg_match('/_(\d+)x(\d+).*\.(jpg|jpeg|png|gif)/i', $resourcesPath, $matches)) {

            if (!isset($matches[0]) || !isset($matches[1]) || !isset($matches[2]) || !isset($matches[3]))
                throw new HttpException(400, 'Non valid params');

            if (!$matches[1] || !$matches[2]) {
                throw new HttpException(400, 'Invalid dimensions');
            }

            $originalFile = str_replace($matches[0], '', $resourcesPath);

            if (!file_exists($originalFile))
                throw new HttpException(404, 'File not found');

            //-------------------------------------------------------------\\
            $thumbDirName = dirname($targetPath);
            if (!is_dir($thumbDirName)){
                mkdir($thumbDirName, 0775, true);
            }
            //-------------------------------------------------------------//

            /*
            $image = Yii::app()->image->load($originalFile);
            $image->resize($matches[1], $matches[2]);

            if ($image->save($targetPath)) {
                if (Yii::app()->request->urlReferrer != Yii::app()->request->requestUri)
                    $this->refresh();
            }*/
            /*
            $phpThumb = AppComponent::phpThumb()->create($originalFile);
            //$phpThumb->resize(550,800);
            $phpThumb->adaptiveResize($matches[1], $matches[2]);
            $phpThumb->save($targetPath);
            */
            /*
            Image::frame($originalFile, 5, '666', 0)
                // ->rotate(-8)
                ->resize(new Box($matches[1],$matches[2]))
                ->save($targetPath, ['quality' => 75]);
            */
            Image::thumbnail($originalFile,$matches[1],$matches[2], ManipulatorInterface::THUMBNAIL_INSET)
                 ->save($targetPath, ['quality' => 75]);

            if(is_file($targetPath)){
                if (Yii::$app->request->referrer != Yii::$app->request->getUrl())
                    $this->refresh();
            }

            throw new HttpException(500, 'Server error');
        } else {
            throw new HttpException(400, 'Wrong params');
        }
    }
    public function actionThumbs0()
    {

       //print_r(Yii::$app->request->get());

        $imgSrc = Yii::$app->request->get('img-src');


       // echo Url::to([$this->route,'img-src'=>'anySrc.jpg']);
        die(__METHOD__);
        // $request = str_replace(DIRECTORY_SEPARATOR . 'thumbs', '', Yii::app()->request->requestUri);
        // $resourcesPath = Yii::getPathOfAlias('webroot') . $request;

        $request = str_replace('/public/thumbs', '', Yii::app()->request->requestUri);

        $resourcesPath = Yii::getPathOfAlias('webroot') . substr($request,strlen(bu())) ;
        $targetPath = Yii::getPathOfAlias('webroot') . substr(Yii::app()->request->requestUri,strlen(bu()));

        //die($targetPath);

        if (preg_match('/_(\d+)x(\d+).*\.(jpg|jpeg|png|gif)/i', $resourcesPath, $matches)) {

            if (!isset($matches[0]) || !isset($matches[1]) || !isset($matches[2]) || !isset($matches[3]))
                throw new CHttpException(400, 'Non valid params');

            if (!$matches[1] || !$matches[2]) {
                throw new CHttpException(400, 'Invalid dimensions');
            }

            $originalFile = str_replace($matches[0], '', $resourcesPath);


            if (!file_exists($originalFile))
                throw new CHttpException(404, 'File not found');

            $dirname = dirname($targetPath);

            // die($matches[0]);

            if (!is_dir($dirname))
                mkdir($dirname, 0775, true);

            /*
            $image = Yii::app()->image->load($originalFile);
            $image->resize($matches[1], $matches[2]);

            if ($image->save($targetPath)) {
                if (Yii::app()->request->urlReferrer != Yii::app()->request->requestUri)
                    $this->refresh();
            }*/
            $phpThumb = AppComponent::phpThumb()->create($originalFile);
            //$phpThumb->resize(550,800);
            $phpThumb->adaptiveResize($matches[1], $matches[2]);
            $phpThumb->save($targetPath);
            if(is_file($targetPath)){
                if (Yii::app()->request->urlReferrer != Yii::app()->request->requestUri)
                    $this->refresh();
            }

            throw new CHttpException(500, 'Server error');
        } else {
            throw new CHttpException(400, 'Wrong params');
        }
    }

    /**
     * @see http://de2.php.net/fpassthrug
     *
     * @param string $filePath
     *
     *   header('Content-Type: image/gif');
     *   header('Content-Type: image/jpeg');
     *   header('Content-Type: image/png');
     *     readfile('path/to/myimage.gif');
     *
     *    You can use the same header functions for sending other mime types as well, for example when sending a PDF or Flash file to the browser.
     *
     */
    protected function serveImageFile($filePath='')
    {

// open the file in a binary mode

        $fp = fopen($filePath, 'rb');

// send the right headers
        header("Content-Type: image/png");
        header("Content-Length: " . filesize($filePath));

// dump the picture and stop the script
        fpassthru($fp);
        exit;

    }

} 