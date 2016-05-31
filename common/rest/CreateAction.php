<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/31
 * Time: 10:29
 */

namespace common\rest;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

/**
 * + ----------------------------------------------------------------------------- +
 *
 *    原始的实现 不支持带表单名称的字段提交:  Comment[user_name] = yiqing
 *    现在扩展一个formName 字段可使之支持通过ActiveForm 生成的表单的提交
 *
 * + ----------------------------------------------------------------------------- +
 *
 * Class CreateAction
 * @package common\rest
 */
class CreateAction extends \yii\rest\CreateAction
{
    public $formName = '' ;

    /**
     * Creates a new model.
     * @return \yii\db\ActiveRecordInterface the model newly created
     * @throws ServerErrorHttpException if there is any error when creating the model
     */
    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);
        // 这里通过配置的方式 可以处理ActiveForm 形式的表单提交
        $model->load(Yii::$app->getRequest()->getBodyParams(), $this->formName);
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }
}