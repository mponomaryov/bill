<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%organization}}".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $itn
 * @property string|null $iec
 * @property string $current_account
 * @property string $bank
 * @property string $corresponding_account
 * @property string $bic
 *
 * @property Bill[] $bills
 *
 * @property string $itnIec
 * @property string asShortString
 * @property string asFullString
 */
class Organization extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organization}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'name',
                    'address',
                    'itn',
                    'current_account',
                    'bank',
                    'corresponding_account',
                    'bic',
                ],
                'required',
            ],
            [
                [
                    'name',
                    'address',
                    'bank',
                ],
                'string',
                'max' => 255,
            ],
            [
                'itn',
                'string',
                'max' => 12,
            ],
            [
                [
                    'iec',
                    'bic',
                ],
                'string',
                'max' => 9,
            ],
            [
                [
                    'current_account',
                    'corresponding_account',
                ],
                'string',
                'max' => 20,
            ],
            [
                [
                    'itn',
                    'iec',
                ],
                'unique',
                'targetAttribute' => ['itn', 'iec'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'itn' => 'ITN',
            'iec' => 'IEC',
            'current_account' => 'Current Account',
            'bank' => 'Bank',
            'corresponding_account' => 'Corresponding Account',
            'bic' => 'BIC',
        ];
    }

    /**
     * Gets query for [[Bills]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBills()
    {
        return $this->hasMany(Bill::className(), ['payer_id' => 'id'])
            ->inverseOf('payer');
    }

    /**
     * Gets string that contain ITN and IEC divided by slash or
     * only ITN if IEC is empty
     *
     * @return string
     */
    public function getItnIec()
    {
        return implode('/', array_filter([$this->itn, $this->iec]));
    }

    /**
     * Gets string that contain organization name, ITN and IEC
     * divided by slash
     *
     * @return string
     */
    public function getAsShortString()
    {
        return implode(' ', [$this->name, $this->itnIec]);
    }

    /**
     * Gets string that contain organization name, ITN and IEC
     * divided by slash and organization address
     *
     * @return string
     */
    public function getAsFullString()
    {
        return vsprintf('%s, ИНН %s, %s', [
            $this->name,
            $this->itnIec,
            $this->address
        ]);
    }
}
