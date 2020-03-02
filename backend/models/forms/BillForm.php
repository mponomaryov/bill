<?php
namespace backend\models\forms;

use common\models\Organization;

class BillForm extends \common\models\forms\BillForm
{
    const SCENARIO_EXIST_ORGANIZATION = 'existOrganization';
    const SCENARIO_NEW_ORGANIZATION = 'newOrganization';

    public $payer_id;

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_NEW_ORGANIZATION] = [
            'name', 'address', 'itn', 'iec', 'current_account', 'bank',
            'corresponding_account', 'bic', 'quantity',
        ];
        $scenarios[self::SCENARIO_EXIST_ORGANIZATION] = [
            'payer_id', 'quantity',
        ];

        return $scenarios;
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['itn', 'iec'],
                'unique',
                'targetClass' => Organization::className(),
                'targetAttribute' => ['itn', 'iec'],
            ],
            [
                ['name', 'itn', 'iec'],
                'unique',
                'targetClass' => Organization::className(),
                'targetAttribute' => ['name', 'itn', 'iec'],
            ],
            ['payer_id', 'required'],
            [
                'payer_id',
                'exist',
                'targetClass' => Organization::className(),
                'targetAttribute' => ['payer_id' => 'id'],
            ],
        ]);
    }

    protected function findOrCreateOrganization()
    {
        if ($this->scenario === self::SCENARIO_EXIST_ORGANIZATION) {
            return Organization::findOne(['id' => $this->payer_id]);
        }

        $organization = new Organization(
            $this->getAttributes(null, ['payer_id', 'quantity'])
        );
        $organization->save(false);

        return $organization;
    }
}
