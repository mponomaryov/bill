<?php
namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use yii\validators\Validator;

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
    public $sum;

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
            [['name', 'address', 'itn', 'iec', 'currentAccount', 'bankName', 'correspondingAccount', 'bic', 'sum'], 'trim'],
            [['name', 'address', 'itn', 'currentAccount', 'bankName', 'correspondingAccount', 'bic', 'sum'], 'required'],
            [['itn', 'currentAccount', 'correspondingAccount', 'bic'], 'match', 'pattern' => $allDigits, 'message' => $allDigitsMessage],
            [['currentAccount', 'correspondingAccount'], 'string', 'min' => 20, 'max' => 20],
            ['bic', 'string', 'min' => 9, 'max' => 9],
            ['sum', 'integer', 'min' => 1],
            ['sum', 'default', 'value' => 1],
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
}
