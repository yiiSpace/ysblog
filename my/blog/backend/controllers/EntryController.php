<?php

namespace my\blog\backend\controllers;

use my\blog\common\models\forms\Image;
use Yii;
use my\blog\common\models\Entry;
use my\blog\common\models\EntrySearch;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EntryController implements the CRUD actions for Entry model.
 */
class EntryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Entry models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
       //  Entry::find()->createCommand()->rawSql ;

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Entry model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Entry();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', sprintf('entry %s 成功创建 !', $model->title));

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 处理文件上传
     *
     * @return string
     */
    public function actionImageUpload()
    {
        $model = new Image() ;
        if ($model->load(Yii::$app->request->post())) {
            /**
             * @var \yii\web\UploadedFile
             */
            $model->file  = UploadedFile::getInstance($model,'file') ;
            if ($model->validate()) {
                $destinationPath = Yii::$app->params['uploadsDir']
                    .'/'.date('Y-m-d').'/'
                    .microtime(true)
                    .'.'.$model->file->getExtension() ;

                $destinationPath = Yii::getAlias($destinationPath) ;
                $destinationDir = dirname($destinationPath);
                if(!is_dir($destinationDir)){
                    mkdir($destinationDir,0777,true) ;
                }
                $model->file->saveAs($destinationPath);

                $img = Html::img('data:image/gif;base64,' . base64_encode(file_get_contents($destinationPath)), ['width' => '300px']);

                // 删除掉所上传的文件
                // 轻轻的我走了正如我轻轻的来 挥一挥手 不留下一点垃圾！

                $result = '上传的图片： ' . $img . '<br/>上传成功 文件已被删除了';
            }
        }

         return $this->render('image-upload',[
            'model'=>$model ,
             'result'=>$result ,
         ]);
    }

    /**
     * Updates an existing Entry model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', "修改成功!");

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->loadTagText() ;

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Entry model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', sprintf('entry %s 成功删除 !', $model->title));

        return $this->redirect(['index']);
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
