<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/6
 * Time: 11:23
 */

namespace my\comment\widgets\profile;


use my\user\widgets\UserProfileView;

class UserProfile extends UserProfileView
{


    public function run()
    {
        return $this->render('user-profile',[
            'profileHead'=>parent::renderProfileHead() ,
        ]) ;
    }
}