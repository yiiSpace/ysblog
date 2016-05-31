<?php

namespace my\comment\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use my\comment\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `my\comment\models\Comment`.
 */
class CommentSearch extends Comment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'entity_id'], 'integer'],
            [['user_name', 'email', 'url', 'ip', 'body', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'entity_id' => $this->entity_id,
        ]);

        $query->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
