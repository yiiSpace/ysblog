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



    // + --------------------------------------------------------------------------------------------------  ++ |
    //                                       ## copy from yii1 blog demo

    /**
     * todo 调整实现
     *
     * Returns tag names and their corresponding weights.
     * Only the tags with the top weights will be returned.
     * @param integer the maximum number of tags that should be returned
     * @return array weights indexed by tag names.
     */
    public function findTagWeights($limit = 20)
    {
        $models = $this->find()->where(array(
            'order' => 'frequency DESC',
            'limit' => $limit,
        ));

        $total = 0;
        foreach ($models as $model)
            $total += $model->frequency;

        $tags = array();
        if ($total > 0) {
            foreach ($models as $model)
                $tags[$model->name] = 8 + (int)(16 * $model->frequency / ($total + 10));
            ksort($tags);
        }
        return $tags;
    }

    /**
     * todo 调整
     *
     * Suggests a list of existing tags matching the specified keyword.
     * @param string the keyword to be matched
     * @param integer maximum number of tags to be returned
     * @return array list of matching tag names
     */
    public function suggestTags($keyword, $limit = 20)
    {
        $tags = $this->findAll(array(
            'condition' => 'name LIKE :keyword',
            'order' => 'frequency DESC, Name',
            'limit' => $limit,
            'params' => array(
                ':keyword' => '%' . strtr($keyword, array('%' => '\%', '_' => '\_', '\\' => '\\\\')) . '%',
            ),
        ));
        $names = array();
        foreach ($tags as $tag)
            $names[] = $tag->name;
        return $names;
    }

    /**
     * @param $tags
     * @return array
     */
    public static function string2array($tags)
    {
        return preg_split('/\s*,\s*/', trim($tags), -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * @param $tags
     * @return string
     */
    public static function array2string($tags)
    {
        return implode(', ', $tags);
    }

    /**
     * @param $oldTags
     * @param $newTags
     */
    public function updateFrequency($oldTags, $newTags)
    {
        $oldTags = self::string2array($oldTags);
        $newTags = self::string2array($newTags);
        $this->addTags(array_values(array_diff($newTags, $oldTags)));
        $this->removeTags(array_values(array_diff($oldTags, $newTags)));
    }

    /**
     * @param $tags
     */
    public function addTags($tags)
    {
        /*
        $criteria=new CDbCriteria;
        $criteria->addInCondition('name',$tags);
        $this->updateCounters(array('frequency'=>1),$criteria);
        */
        foreach ($tags as $name) {
            $query = static::find();
            $query->where([
                'title' => $name,
            ]);
            if (!$query->exists()) {
                $tag = new Tag;
                $tag->title = $name;
                // $tag->frequency=1; # 后续实现词频功能
                $tag->save();
            }
        }
    }

    public function removeTags($tags)
    {
        /*
        if (empty($tags))
            return;
        $criteria = new CDbCriteria;
        $criteria->addInCondition('name', $tags);
        $this->updateCounters(array('frequency' => -1), $criteria);
        $this->deleteAll('frequency<=0');
        */
    }

    // + --------------------------------------------------------------------------------------------------  ++ |
}
