<?php
namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use yii\validators\Validator;

use common\models\Bill;
use common\models\Organization;
use common\models\BillItem;

class ItnLengthValidator extends Validator
{
    public $message = 'length must be 10 or 12 symbols';

    public function validateAttribute($model, $attribute)
    {
        $length = mb_strlen($model->$attribute, 'UTF-8');

        if (!in_array($length, [10, 12])) {
            $this->addError($attribute, $this->message);
        }

    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        $lengths = json_encode([10, 12]);
        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return "if ($.inArray(value.length, $lengths) === -1) {
            messages.push($message);
        }";
    }
}

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
        ];
    }

    public function createBill()
    {
        /* A minute of shitty code */

        if (!$this->validate()) {
            return;
        }

        $organization = Organization::findOne([
            'name' => $this->name,
            'address' => $this->address,
            'itn' => $this->itn,
            'iec' => $this-> iec,
            'current_account' => $this->currentAccount,
            'bank' => $this->bankName,
            'corresponding_account' => $this->correspondingAccount,
            'bic' => $this->bic,
        ]);

        if (!$organization) {
            $organization = new Organization();
            
            $organization->name = $this->name;
            $organization->address = $this->address;
            $organization->itn = $this->itn;
            $organization->iec = $this->iec;
            $organization->current_account = $this->currentAccount;
            $organization->bank = $this->bankName;
            $organization->corresponding_account = $this->correspondingAccount;
            $organization->bic = $this->bic;

            $organization->save();
        }

        $bill = new Bill();
        $bill->setDefaultValues();
        $bill->link('payer', $organization);

        $stubBillItem = new BillItem();
        $stubBillItem->item_id = 1;
        $stubBillItem->quantity = $this->quantity;

        $bill->link('billItems', $stubBillItem);
        $bill->refresh();

        return $bill;
    }
}
