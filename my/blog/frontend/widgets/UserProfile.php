<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/6/6
 * Time: 10:17
 */

namespace my\blog\frontend\widgets;

use Yii ;
use my\blog\common\models\Entry;
use my\blog\common\models\EntrySearch;
use my\user\widgets\UserProfileView;

class UserProfile extends UserProfileView
{

    public function run()
    {
        $searchModel = new EntrySearch();

        $request = Yii::$app->request;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = $dataProvider->query;

        // 对作者特殊处理
        // $this->filterStatusByUser($query);

        $validateStatuses = [Entry::STATUS_PUBLIC, Entry::STATUS_DRAFT];
        $query->andWhere([
            'status' => $validateStatuses,
        ]);

        $dataProvider->pagination->pageSize = 10 ;
        // var_dump( parent::className() );
        // var_dump( parent::render('user-profile') );
        // return parent::run() ;
        return $this->render('user-profile', [
            'profileHead' => parent::renderProfileHead(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}