<?php

namespace my\blog\common\models;

use my\comment\models\Comment;
use my\user\models\User;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\StringHelper;

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
     * @var string
     */
    public $tag_text = '';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body'], 'string'],
            // 从yii1 拷贝过来的 fixme 汉语tag支持有问题！
            [['tag_text'], 'match',
                'pattern' => '/^[\w\s,]+$/u', 'message' => 'Tags can only contain word characters.'],
            // [['created_at', 'updated_at'], 'required'],
            [['title', 'body'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 100],
            [['slug'], 'unique'],

            [['status'], 'default', 'value' => static::STATUS_DRAFT],
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
            'tag_text' => 'tags',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    const STATUS_PUBLIC = 0;
    const STATUS_DRAFT = 1;
    const STATUS_DELETED = 2;

    /**
     * available status choices
     * 此方法别名可以是 getStatusChoices  ? 这个看起来怎么样 ^_^
     * OK 的到引证确实可以叫 此名
     * ---------------------------------------------------------------------------+
     * class EntryModelView(ModelView):
     * _status_choices = [(choice, label) for choice, label in [
     * (Entry.STATUS_PUBLIC, 'Public'),
     * (Entry.STATUS_DRAFT, 'Draft'),
     * (Entry.STATUS_DELETED, 'Deleted'),
     * ]]
     * column_choices = {
     * 'status': _status_choices,
     * }
     * --------------------------------------------------------------------------- +
     *
     * @return array
     */
    public static function getStatusOptions()
    {
        return [
            static::STATUS_DRAFT => 'DRAFT',
            static::STATUS_PUBLIC => 'PUBLIC',
            static::STATUS_DELETED => 'DELETED',
        ];
    }

    /**
     * 枚举状态的 可读化展示
     * 可选名  statusLabel
     * @return mixed
     */
    public function getStatusTitle()
    {
        $statusChoices = static::getStatusOptions();
        return $statusChoices[$this->status];
    }

    /**
     * @return $this
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('{{entry_tag}}', ['entry_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                // 'value' => new Expression('NOW()'),
            ],
            [
                // 好牛呀  竟然可以自动生成汉语拼音
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'slug',
            ],
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        // 更新tag关系
        if ($insert) {

        } else {
            // 移除tag关系
            // $this->unlinkAll('tags') ;
            $sql = <<<SQL
        DELETE
        FROM {{entry_tag}}
        WHERE    entry_id = :entry_id;
SQL;

            $cmd = Yii::$app->db->createCommand($sql, [':entry_id' => $this->primaryKey]);
            $cmd->execute();
        }

        $newTags = Tag::string2array($this->tag_text);
        Tag::addTags(array_values($newTags));
        $tagModels = Tag::find()
            ->where([
                'title' => $newTags,
            ])
            ->all();
        foreach ($tagModels as $tagModel) {
            $this->link('tags', $tagModel);
        }

    }

    /**
     * Normalizes the user-entered tags.
     */
    public function loadTagText()
    {

        $this->tag_text = '';
        if (!empty($this->tags)) {
            $tagTitles = array_map(function ($tagModel) {
                return $tagModel->title;
            }, $this->tags);
            $this->tag_text = implode(', ', $tagTitles);
        }
    }

    /**
     * @return string
     */
    public function getTagList()
    {
        return join(', ', array_map(function ($tag) {
            return $tag->title;
        }, $this->tags));
    }

    /**
     * @return string
     */
    public function getTease()
    {
        return StringHelper::truncate($this->body, 100);
    }

    /**
     * 所属关系
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        /**
         *  因为是实例方法  所以其实是可以用$this->attributeName 来访问属性 构造一个查询的 这个给人感觉很怪的 如果这样用
         * 明显感觉到yii使用了 多次查询的技巧 而实际上也是！:)
         */
        return $this->hasOne(User::className(), [
            'id' => 'user_id',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany( Comment::className(),['entity_id'=>'id']);
    }
}
