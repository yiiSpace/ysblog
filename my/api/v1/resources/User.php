<?php

namespace my\api\v1\resources;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class User extends \my\user\models\User
{
    public function fields()
    {
        return ['id', 'username', 'created_at'];
    }

    public function extraFields()
    {
        return ['userProfile'];
    }
}
