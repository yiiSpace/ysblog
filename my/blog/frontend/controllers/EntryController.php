<?php

namespace my\blog\frontend\controllers;

use my\blog\common\models\Entry;
use Yii;
use my\blog\common\models\EntrySearch;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class EntryController extends \yii\web\Controller
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
                        'actions' => ['index', 'view','detail'],
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

        // 对作者特殊处理
        $this->filterStatusByUser($query) ;

        $validateStatuses = [Entry::STATUS_PUBLIC, Entry::STATUS_DRAFT];
        $query->andWhere([
            'status' => $validateStatuses,
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

    protected function filterStatusByUser(Query $query)
    {
        $webUser = Yii::$app->user;
        if($webUser->getIsGuest()){
            $query->filterWhere([
                'status'=>Entry::STATUS_PUBLIC,
            ]);
        }else{
            # Allow user to view their own drafts.
            $query->andWhere([
               'status'=>Entry::STATUS_PUBLIC,
            ]);
            $query->orWhere([
              'AND' , [
                    'user_id'=>$webUser->id,
                ],
                [
                    '<>','status',Entry::STATUS_DELETED
                ]
            ]);
        }
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
     * Displays a single Entry model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        // FIXME 这里最好改造下findModel函数 允许传入额外的条件 或者query
        $model = $this->findModel($id);
        if ($model->status == Entry::STATUS_DELETED) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Entry model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id,Yii::$app->user->id);
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
         * TODO 实际是前台才需要这种逻辑 后台是管理员 是不需要这种逻辑的
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
