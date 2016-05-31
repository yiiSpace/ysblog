<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/31
 * Time: 9:12
 */

namespace my\comment\widgets;

use Yii ;
use my\comment\models\Comment;

/**
 * Class CommentForm
 * @package my\comment\widgets
 */
class CommentForm extends \yii\base\Widget
{
    /**
     * @var string|null
     */
    public $theme;
    /**
     * @var string|int
     * */
    public $entity_id;
    /**
     * @var
     */
    public $Comment;
    /**
     * @var string
     */
    public $anchor = '#comment-%d';

    /**
     * @inheritdoc
     */
    public function run()
    {
        /*
        CommentFormAsset::register($this->getView());
        $CommentCreateForm = new Comments\forms\CommentCreateForm([
            'Comment' => $this->Comment,
            'entity' => $this->entity,
        ]);
        if ($CommentCreateForm->load(\Yii::$app->getRequest()->post())) {
            if ($CommentCreateForm->validate()) {
                if ($CommentCreateForm->save()) {
                    \Yii::$app->getResponse()
                        ->refresh(sprintf($this->anchor, $CommentCreateForm->Comment->id))
                        ->send();
                    exit;
                }
            }
        }
        */
        $model = new Comment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            \Yii::$app->getResponse()
                ->refresh(sprintf($this->anchor, 1))
                ->send();
            exit;
        } else {
            $model->entity_id = $this->entity_id ;
            return $this->render('comment-form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function getViewPath()
    {
        if (empty($this->theme)) {
            return parent::getViewPath();
        } else {
            return \Yii::$app->getViewPath() . DIRECTORY_SEPARATOR . $this->theme;
        }
    }
}