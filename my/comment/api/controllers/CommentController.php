<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/30
 * Time: 23:09
 */

namespace my\comment\api\controllers;


use common\rest\CreateAction;
use common\rest\Util;
use my\comment\models\Comment;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\HttpException;

class CommentController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = 'my\comment\models\Comment';
    /**
     * @var array
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items'
    ];

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $rc = new \ReflectionClass(Comment::className());
        $formName = $rc->getShortName();
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => [$this, 'prepareDataProvider']
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'findModel' => [$this, 'findModel']
            ],
//            'create0' => [
            'create' => [
                'class' => CreateAction::className(), //  'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
                'formName' => $formName,
            ],
            'update' => [
                'class' => 'yii\rest\UpdateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->updateScenario,
            ],
            'delete' => [
                'class' => 'yii\rest\DeleteAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction'
            ]
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'create') {

            //            $post = \Yii::$app->request->post() ;
            // 如果是yii 风格的ActiveForm提交的
            $post = \Yii::$app->request->getBodyParams();
            // TODO  遍历post数据 转为不带表单名称的 内容
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionCreate2()
    {
        return \Yii::$app->request->post();
        return $_POST;
        return \Yii::$app->request->getRawBody();
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        /**
         * FIXME   关于API的过滤问题 跟传统表单提交稍微不同 你自己要处理他们 客户端到底怎样提交 可以协商
         *
         *                  ##   比如下面这种flask 就可以把js中的 filters 转换为自己query的操作
         *                           Yii 中 我们自己也可以商定一些操作规范哦
         *                           因为这些直接对应Query的方法上 所以最好参考：Query::andFilterCompare
         *                           此方法是2.0.8 新增的 对比下面这种js的格式 可以很好做转换的
         *                     foreach($filters as $filterItem){
         *
         *                          $query->andFilterCompare($filterItem['name'] ,$filterItem['val'],$filterItem['op'] )
         *                     }
         *
         * +   -----------------------------------------------------------------------------  ++
         *  var filters = [{
         * 'name': 'entry_id',
         * 'op': 'eq',  // 这个地方可以映射  eq <==> =  , neq <==> <> , gt <==> >   有好多常用的！
         * 'val': entryId
         * }];
         * var serializedQuery = JSON.stringify({'filters': filters});
         *
         * $.get(commentListUrl, {'q': serializedQuery}, function (data) {
         *          if (data['num_results'] === 0) {
         *              displayNoComments();
         *          } else {
         *              displayComments(data['objects']);
         *          }
         * });
         * +   -----------------------------------------------------------------------------  ++
         */


        // 这里可以获取相关的请求 用来构造一个query  然后在构造一个DataProvider 就完事了！
        // return \Yii::$app->request->get() ;
        $filters = \Yii::$app->request->get('q');
        $filters = Json::decode($filters);
        $filters = $filters['filters'];
        //  return $filters;

        $query = Comment::find();
        /*
        $query->filterWhere([
            'entity_id' => $filter['val'],
        ]);
        */
        //  $query->andFilterCompare('entity_id',$filter['val']) ;
        foreach ($filters as $filter) {
            $query->andFilterCompare($filter['name'], $filter['val'], Util::safeFilterOperator($filter['op']));
        }

        // 看看原始sql长啥样
        // return $query->createCommand()->rawSql;

        return new ActiveDataProvider(array(
            'query' => $query,
        ));
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    public function findModel($id)
    {
        $model = Comment::find()
            // ->published()
            ->andWhere(['id' => (int)$id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }
        return $model;
    }
}