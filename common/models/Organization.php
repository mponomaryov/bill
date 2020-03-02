<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

use common\models\RequisitesTrait;

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
    use RequisitesTrait {
        RequisitesTrait::rules as baseRules;
    }

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
        return array_merge($this->baseRules(), [
            [
                ['itn', 'iec'],
                'unique',
                'targetAttribute' => ['itn', 'iec'],
            ],
            [
                ['name', 'itn', 'iec'],
                'unique',
                'targetAttribute' => ['name', 'itn', 'iec'],
            ],
        ]);
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
