<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/6
 * Time: 9:57
 */

namespace my\user\components;


// use my\blog\frontend\widgets\UserProfile;
use my\blog\frontend\widgets\UserProfile;
use my\user\widgets\UserProfileView;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * 参考i18n组件
 *
 * Class ProfileHub
 * @package my\user\components
 */
class ProfileHub extends Component
{
    public $profileViews = [
        'blog'=>'my\blog\frontend\widgets\UserProfile' ,

    ];

    public function process($nav='')
    {
        $profileView = $this->getProfileView($nav);
        // var_dump($profileView) ;
        return call_user_func([$profileView,'widget'],[]);
    }

    /**
     * @param string $nav
     * @return UserProfileView|array
     */
    public function getProfileView($nav='')
    {
        if (isset($this->profileViews[$nav])) {
           return $this->profileViews[$nav] ;
        } else {
            // try wildcard matching
            foreach ($this->profileViews as $pattern => $profileView) {
                if (strpos($pattern, '*') > 0 && strpos($nav, rtrim($pattern, '*')) === 0) {
                   return $profileView ;
                }
            }
            // match '*' in the last
            // ... TODO

            // fallback  默认的
            if(empty($nav)){
                return UserProfile::className() ;
            }

        }

        throw new InvalidConfigException("Unable to locate profileView for category '$nav'.");
    }
}