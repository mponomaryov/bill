<?php
namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\base\Model;

use common\components\LengthsValidator;

const SOLE_PROPRIETOR_ITN_LENGTH = 10;
const LEGAL_ENTITY_ITN_LENGTH = 12;
const IEC_LENGTH = 9;
const BANK_ACCOUNT_LENGTH = 20;
const BIC_LENGTH = 9;

/**
 * Requisites trait
 */
trait RequisitesTrait
{
    public function rules()
    {
        $allDigits = '/^\d+$/';
        $allDigitsMessage = '{attribute} should contain only digits';

        $length = LEGAL_ENTITY_ITN_LENGTH;
        $isIecRequired = function ($model) use($length) {
            return mb_strlen($model->itn, 'UTF-8') === $length;
        };
        $itnInputId = Html::getInputId($this, 'itn');
        $isIecRequiredClient = "function (attribute, value) {
            return $('#{$itnInputId}').val().length === {$length};
        }";

        return [
            [
                [
                    'name', 'address', 'itn', 'iec', 'current_account',
                    'bank', 'corresponding_account', 'bic'
                ],
                'trim',
            ],
            [
                [
                    'name', 'address', 'itn', 'current_account', 'bank',
                    'corresponding_account', 'bic'
                ],
                'required',
            ],
            [
                ['itn', 'current_account', 'corresponding_account', 'bic'],
                'match',
                'pattern' => $allDigits,
                'message' => $allDigitsMessage,
            ],
            [
                ['current_account', 'corresponding_account'],
                'string',
                'min' => BANK_ACCOUNT_LENGTH,
                'max' => BANK_ACCOUNT_LENGTH,
            ],
            [
                'bic',
                'string',
                'min' => BIC_LENGTH,
                'max' => BIC_LENGTH,
            ],
            [
                'itn',
                LengthsValidator::className(),
                'validLengths' => [
                    SOLE_PROPRIETOR_ITN_LENGTH,
                    LEGAL_ENTITY_ITN_LENGTH,
                ],
            ],
            [
                'iec',
                'required',
                'when' => $isIecRequired,
                'whenClient' => $isIecRequiredClient
            ],
            [
                'iec',
                'match',
                'pattern' => $allDigits,
                'message' => $allDigitsMessage
            ],
            [
                'iec',
                'string',
                'min' => IEC_LENGTH,
                'max' => IEC_LENGTH
            ],
            ['iec', 'default', 'value' => null],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'address' => 'Адрес',
            'itn' => 'ИНН',
            'iec' => 'КПП',
            'current_account' => 'Р/сч',
            'bank' => 'Банк',
            'corresponding_account' => 'Кор. счет',
            'bic' => 'БИК',
        ];
    }
}
