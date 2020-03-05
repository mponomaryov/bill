<?php
namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\base\Model;

use common\components\LengthsValidator;

/**
 * Requisites trait
 */
trait RequisitesTrait
{
    public function rules()
    {
        $params = Yii::$app->params;

        $allDigits = '/^\d+$/';
        $allDigitsMessage = '{attribute} should contain only digits';

        $length = $params['legalEntityItnLength'];
        $isIecRequired = function ($model) use ($length) {
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
                'min' => $params['bankAccountLength'],
                'max' => $params['bankAccountLength'],
            ],
            [
                'bic',
                'string',
                'min' => $params['bicLength'],
                'max' => $params['bicLength'],
            ],
            [
                'itn',
                LengthsValidator::className(),
                'validLengths' => [
                    $params['soleProprietorItnLength'],
                    $params['legalEntityItnLength'],
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
                'min' => $params['iecLength'],
                'max' => $params['iecLength'],
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
