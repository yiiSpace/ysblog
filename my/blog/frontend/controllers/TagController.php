<?php

namespace my\blog\frontend\controllers;

use Yii ;
use my\blog\common\models\Tag;
use my\blog\common\models\TagSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class TagController extends \yii\web\Controller
{


    /**
     * @param string $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDetail($slug = '')
    {

        /** @var Tag $model * */
        $model = Tag::find()->where([ 'OR',[ 'slug' => $slug,],['title'=>$slug]])->one();
        if ($model !== null) {
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $query = $model->getEntries();
        $query->orderBy([
            'id' => SORT_DESC,
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('detail',[
            'model'=>$model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Tag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
