<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;

use common\models\Bill;
use common\models\Item;
use common\models\Organization;
use common\models\RequisitesTrait;

class BillForm extends Model
{
    const SCENARIO_EXIST_ORGANIZATION = 'existOrganization';
    const SCENARIO_NEW_ORGANIZATION = 'newOrganization';

    public $name;
    public $address;
    public $itn;
    public $iec;
    public $current_account;
    public $bank;
    public $corresponding_account;
    public $bic;

    public $payer_id;

    public $quantity;
    
    use RequisitesTrait {
        RequisitesTrait::rules as baseRules;
        RequisitesTrait::attributeLabels as baseAttributeLabels;
    }

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
        return array_merge($this->baseRules(), [
            [['payer_id', 'quantity'], 'required'],
            [
                'payer_id',
                'exist',
                'targetClass' => Organization::className(),
                'targetAttribute' => ['payer_id' => 'id'],
            ],
            ['quantity', 'integer', 'min' => 1],
            ['quantity', 'default', 'value' => 1],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge($this->baseAttributeLabels(), [
            'quantity' => 'Количество',
        ]);
    }

    public function save()
    {
        if (!$this->validate()) {
            return;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($this->scenario === self::SCENARIO_EXIST_ORGANIZATION) {
                $organization = Organization::findOne([
                    'id' => $this->payer_id,
                ]);
            } else {
                $organization = new Organization(
                    $this->getAttributes(null, ['payer_id', 'quantity'])
                );
                $organization->save(false);
            }

            $bill = new Bill();
            $bill->setDefaultValues();
            $bill->link('payer', $organization);
            $bill->link('items', Item::findOne(['id' => 1]), [
                'quantity' => $this->quantity,
            ]);
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        $transaction->commit();

        $bill->refresh();

        return $bill;
    }
}
