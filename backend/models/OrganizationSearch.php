<?php
namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\models\Organization;

/**
 * OrganizationSearch represents the model behind the search
 * form of `common\models\Organization`.
 */
class OrganizationSearch extends Organization
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            [
                [
                    'name', 'address', 'itn', 'iec', 'current_account',
                    'bank', 'corresponding_account', 'bic'
                ],
                'safe'
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Organization::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'itn', $this->itn])
            ->andFilterWhere(['like', 'iec', $this->iec])
            ->andFilterWhere(['like', 'current_account', $this->current_account])
            ->andFilterWhere(['like', 'bank', $this->bank])
            ->andFilterWhere(['like', 'corresponding_account', $this->corresponding_account])
            ->andFilterWhere(['like', 'bic', $this->bic]);

        return $dataProvider;
    }
}
