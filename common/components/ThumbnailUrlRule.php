<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-19
 * Time: 下午3:53
 */

namespace common\components;

use yii\base\NotSupportedException;
use yii\web\UrlRule;

/**
 *  该类配合UploadsController 来使用的o
 * Class ThumbnailUrlRule
 *
 * @package app\components
 */
class ThumbnailUrlRule extends UrlRule{

    public $route = 'uploads/thumbs';
    public $pattern = 'uploads/thumbs/<imgSrc:.+>';



    public function createUrl($manager, $route, $params)
    {
        if ($route === $this->route) {

            //echo  parent::createUrl($manager,$route,[]); die(__METHOD__);
            // print_r($route);
            //var_dump( parent::createUrl($manager,'yi/qing',['p1'=>'v1'])); die(__METHOD__);


          // throw new NotSupportedException("not implemented it !");

            return $this->route.'/'.current($params);
        }
        return false;  // this rule does not apply
    }

    /**
     * Parses the given request and returns the corresponding route and parameters.
     * @param UrlManager $manager the URL manager
     * @param Request $request the request component
     * @return array|boolean the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if (preg_match('%uploads/thumbs/(.+)%', $pathInfo, $matches)) {
            // check $matches[1] and $matches[3] to see
            // if they match a manufacturer and a model in the database
            // If so, set $params['manufacturer'] and/or $params['model']
            // and return ['car/index', $params]
            $params = ['img-src' => $matches[1]];

            return [$this->route, $params];
        }
        return false;  // this rule does not apply
    }
} 