<?php
namespace frontend\models\forms;

use Yii;
use yii\base\Model;

use common\models\Bill;
use common\models\Organization;
use common\models\Item;
use frontend\components\ItnLengthValidator;

/**
 * Requisites form
 */
class RequisitesForm extends Model
{
    public $name;
    public $address;
    public $itn;
    public $iec;
    public $currentAccount;
    public $bankName;
    public $correspondingAccount;
    public $bic;
    public $quantity;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $isIecRequired = function ($model) {
            return mb_strlen($model->itn, 'UTF-8') === 12;
        };

        $allDigits = '/^\d+$/';
        $allDigitsMessage = '{attribute} should contain only digits';

        $whenIecRequiredClient = "function (attribute, value) {
            return $('#requisitesform-itn').val().length === 12;
        }";

        return [
            [['name', 'address', 'itn', 'iec', 'currentAccount', 'bankName', 'correspondingAccount', 'bic', 'quantity'], 'trim'],
            [['name', 'address', 'itn', 'currentAccount', 'bankName', 'correspondingAccount', 'bic', 'quantity'], 'required'],
            [['itn', 'currentAccount', 'correspondingAccount', 'bic'], 'match', 'pattern' => $allDigits, 'message' => $allDigitsMessage],
            [['currentAccount', 'correspondingAccount'], 'string', 'min' => 20, 'max' => 20],
            ['bic', 'string', 'min' => 9, 'max' => 9],
            ['quantity', 'integer', 'min' => 1],
            ['quantity', 'default', 'value' => 1],
            ['itn', ItnLengthValidator::className()],
            ['iec', 'required', 'when' => $isIecRequired, 'whenClient' => $whenIecRequiredClient],
            ['iec', 'match', 'pattern' => $allDigits, 'message' => $allDigitsMessage],
            ['iec', 'string', 'min' => 9, 'max' => 9],
            ['iec', 'default', 'value' => null],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'address' => 'Адрес',
            'itn' => 'ИНН',
            'iec' => 'КПП',
            'currentAccount' => 'Р/сч',
            'bankName' => 'Банк',
            'correspondingAccount' => 'Кор. счет',
            'bic' => 'БИК',
            'quantity' => 'Количество',
        ];
    }

    public function fields()
    {
        return [
            'name',
            'address',
            'itn',
            'iec',
            'current_account' => 'currentAccount',
            'bank' => 'bankName',
            'corresponding_account' => 'correspondingAccount',
            'bic',
        ];
    }

    public function createBill()
    {
        if (!$this->validate()) {
            return;
        }

        $thisAsArray = $this->toArray();

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $organization = Organization::findOne($thisAsArray);

            if (!$organization) {
                $organization = new Organization();
                $organization->attributes = $thisAsArray;
                $organization->save();
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
