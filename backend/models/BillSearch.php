<?php
namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\models\Bill;

/**
 * BillSearch represents the model behind the search form of `common\models\Bill`.
 */
class BillSearch extends Bill
{
    public $payerName;
    public $payerItn;
    public $payerIec;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payer_id', 'bill_number'], 'integer'],
            [['payerName', 'payerItn', 'payerIec', 'created_at'], 'safe'],
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
        $query = Bill::find()->joinWith(['payer p']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'defaultOrder' => [
                'bill_number' => SORT_DESC,
            ],
            'attributes' => [
                'bill_number',
                'created_at',
                'payerName' => [
                    'asc' => ['p.name' => SORT_ASC],
                    'desc' => ['p.name' => SORT_DESC],
                ],
                'payerItn' => [
                    'asc' => ['p.itn' => SORT_ASC],
                    'desc' => ['p.itn' => SORT_DESC],
                ],
                'payerIec' => [
                    'asc' => ['p.iec' => SORT_ASC],
                    'desc' => ['p.iec' => SORT_DESC],
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'bill_number' => $this->bill_number,
            'created_at' => $this->created_at,
        ])->andFilterWhere(['like', 'p.name', $this->payerName])
            ->andFilterWhere(['like', 'p.itn', $this->payerItn])
            ->andFilterWhere(['like', 'p.iec', $this->payerIec]);

        return $dataProvider;
    }
}
