<?php
namespace backend\models;

use Yii;
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
        $params = Yii::$app->params;

        $allDigitsPattern = '/^\d+$/';
        $allDigitsMessage = '{attribute} should contain only digits';

        return [
            [['name', 'address'], 'string', 'max' => 100],
            ['itn', 'string', 'max' => $params['legalEntityItnLength']],
            ['iec', 'string', 'max' => $params['iecLength']],
            [
                ['itn', 'iec'],
                'match',
                'pattern' => $allDigitsPattern,
                'message' => $allDigitsMessage,
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
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            /* uncomment the following line if you do not want to return
             * any records when validation fails
             */
            $query->where('0 = 1');

            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'itn', $this->itn])
            ->andFilterWhere(['like', 'iec', $this->iec]);

        return $dataProvider;
    }
}
