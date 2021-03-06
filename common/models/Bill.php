<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%bill}}".
 *
 * @property int $id
 * @property int $payer_id
 * @property int $bill_number
 * @property string $created_at
 *
 * @property Organization $payer
 * @property BillItem[] $billItems
 * @property Item[] $items
 */
class Bill extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bill}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'payer_id',
                    //'bill_number',
                    //'created_at',
                ],
                'required',
            ],
            [
                [
                    'payer_id',
                    //'bill_number',
                ],
                'integer',
            ],
            [  // Not processed without explicit validation call
                'bill_number',
                'default',
                'value' => new Expression('get_next_bill_number()'),
                'skipOnEmpty' => false,
                'on' => 'insert',
            ],
            [  // Not processed without explicit validation call
                'created_at',
                'default',
                'value' => new Expression('CURRENT_DATE()'),
                'skipOnEmpty' => false,
                'on' => 'insert',
            ],
            [
                'payer_id',
                'exist',
                'skipOnError' => true,
                'targetClass' => Organization::className(),
                'targetAttribute' => ['payer_id' => 'id'],
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
            'payer_id' => 'Payer ID',
            'bill_number' => 'Bill Number',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Payer]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\OrganizationQuery
     */
    public function getPayer()
    {
        return $this->hasOne(Organization::className(), ['id' => 'payer_id'])
            ->inverseOf('bills');
    }

    /**
     * Gets query for [[BillItems]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\BillItemQuery
     */
    public function getBillItems()
    {
        return $this->hasMany(BillItem::className(), ['bill_id' => 'id'])
            ->inverseOf('bill');
    }

    /**
     * Gets query for [[Items]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ItemQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['id' => 'item_id'])
            ->viaTable('{{%bill_item}}', ['bill_id' => 'id']);
    }

    /**
     * Sets default values if record is new
     */
    public function setDefaultValues()
    {
        if ($this->isNewRecord) {
            $this->bill_number = new Expression('get_next_bill_number()');
            $this->created_at = new Expression('CURRENT_DATE()');
        }
    }
}
