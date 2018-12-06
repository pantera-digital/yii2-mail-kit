<?php

namespace pantera\mail\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

/**
 * MailTemplateSearch represents the model behind the search form of `pantera\mail\models\MailTemplate`.
 */
class MailTemplateSearch extends MailTemplate
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'alias', 'from', 'subject', 'content_type'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
        $query = MailTemplate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'class' => Sort::class,
                'defaultOrder' => ['name' => SORT_ASC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'from', $this->from])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'content_type', $this->content_type]);

        return $dataProvider;
    }
}
