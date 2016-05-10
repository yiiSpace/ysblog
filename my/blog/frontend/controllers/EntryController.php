<?php

namespace my\blog\frontend\controllers;

use my\blog\common\models\Entry;
use Yii;
use my\blog\common\models\EntrySearch;

class EntryController extends \yii\web\Controller
{
    public function actionDetail()
    {
        return $this->render('detail');
    }

    /**
     * Lists all Entry models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntrySearch();

        $request = Yii::$app->request;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = $dataProvider->query;

        $validateStatuses = [Entry::STATUS_PUBLIC , Entry::STATUS_DRAFT] ;
        $query->andWhere([
            'status'=>$validateStatuses ,
        ]);

        if ($search = $request->get('q')) {
            $query
                ->andFilterWhere(['like', 'title', $search])
                ->orFilterWhere(['like', 'slug', $search]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Entry model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        // FIXME 这里最好改造下findModel函数 允许传入额外的条件 或者query
        $model = $this->findModel($id) ;
        if($model->status == Entry::STATUS_DELETED){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }


    /**
     * Finds the Entry model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Entry the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Entry::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
