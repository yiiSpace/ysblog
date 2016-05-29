<?php

namespace my\blog\backend\controllers;

use my\blog\common\models\forms\Image;
use Yii;
use my\blog\common\models\Entry;
use my\blog\common\models\EntrySearch;
use yii\filters\AccessControl;
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view',],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['create', 'delete', 'update',
                            'image-upload'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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

        // var_dump(Yii::$app->user->getIdentity()) ;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // 添加关系 也可以用behavior BlameableBehavior 来做 todo 在前台可以使用这种做法哦
            $model->link('author', Yii::$app->user->getIdentity());

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
        $model = new Image();
        if ($model->load(Yii::$app->request->post())) {
            /**
             * @var \yii\web\UploadedFile
             */
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->validate()) {
                // 相对路径
                $relativePath = '/' . date('Y-m-d') . '/'
                    . microtime(true)
                    . '.' . $model->file->getExtension();
                // 目标路径 带别名的路径
                $destinationPath = Yii::$app->params['uploadsDir'] . $relativePath;

                // 别名计算出真正的路径
                $destinationPath = Yii::getAlias($destinationPath);
                // 目标文件的所在目录
                $destinationDir = dirname($destinationPath);
                // 如果不存在则创建目录
                if (!is_dir($destinationDir)) {
                    mkdir($destinationDir, 0777, true);
                }
                // 上传保存文件 参二默认是true值会删掉当前上传的文件的
                $model->file->saveAs($destinationPath);
                Yii::$app->session->setFlash('success', sprintf('上传文件 %s 成功 !', basename($destinationPath)));

                $img = Html::img('data:image/gif;base64,' . base64_encode(file_get_contents($destinationPath)), ['width' => '300px']);

                // 删除掉所上传的文件
                // 轻轻的我走了正如我轻轻的来 挥一挥手 不留下一点垃圾！
                // unlink($destinationPath ) ;

                $result = '上传的图片： ' . $img . '<br/>上传成功 路径[[' . Yii::getAlias('@web' . $relativePath) . ']]';
            }
        }

        return $this->render('image-upload', [
            'model' => $model,
            'result' => $result,
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
            $model->loadTagText();

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
    protected function findModel($id, $authorId = null)
    {
        /**
         * 只有作者才可以编辑和删除他们的实体 ，
         * TODO 注意这里是后台 实际是前台才需要这种逻辑 后台是管理员 是不需要这种逻辑的
         * +  ------------------------------------------------------------------------------  ++
         *                                 ## 这里实现参考《learning flask》
         * -  g 是flask全局对象 可以存放任何东西
         *
         * ————————————————————————————————————————————
         *      ## only the author can edit or delete their own entries
         *
         * def get_entry_or_404(slug, author=None):
         * query = Entry.query.filter(Entry.slug == slug)
         * if author:
         * query = query.filter(Entry.author == author)
         * else:
         * query = filter_status_by_user(query)
         * return query.first_or_404()
         *
         * ————————————————————————————————————————————
         * 非登陆用户只能看到状态是public的博客
         *
         * def filter_status_by_user(query):
         * if not g.user.is_authenticated:
         * return query.filter(Entry.status == Entry.STATUS_PUBLIC)
         * else:
         * return query.filter(
         * Entry.status.in_((Entry.STATUS_PUBLIC,
         * Entry.STATUS_DRAFT)))
         * -----------------------------------------------------------------------------------------
         */
        $query = Entry::find();
        $query->where([
            'id' => $id,
        ]);
        /*
        if($authorId !== null){
           $query->andWhere([
              'user_id'=>$authorId,
           ]);
        }
        */
        $query->filterWhere([
            'user_id' => $authorId,
        ]);
        // if (($model = Entry::findOne($id)) !== null) {
        if (($model = $query->one()) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
