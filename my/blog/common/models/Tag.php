<?php

namespace my\blog\common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug'], 'string', 'max' => 64],
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
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getEntries()
    {
        return $this->hasMany(Entry::className(), ['id' => 'entry_id'])
            ->viaTable('{{entry_tag}}', ['tag_id' => 'id']);
    }
}
