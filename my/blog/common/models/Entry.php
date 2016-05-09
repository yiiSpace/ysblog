<?php

namespace my\blog\common\models;

use Yii;

/**
 * This is the model class for table "entry".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property integer $created_at
 * @property integer $updated_at
 */
class Entry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body'], 'string'],
            [['created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 100],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'body' => 'Body',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    const STATUS_PUBLIC = 0;
    const STATUS_DRAFT = 1;

    /**
     * @return $this
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(),['id'=>'tag_id'])
            ->viaTable('{{entry_tag}}',['entry_id'=>'id']);
    }
}
