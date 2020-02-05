<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%bill_item}}".
 *
 * @property int $bill_id
 * @property int $item_id
 * @property int $quantity
 *
 * @property Bill $bill
 * @property Item $item
 * @property float $itemTotalPrice
 */
class BillItem extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bill_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'bill_id',
                    'item_id',
                    'quantity',
                ],
                'required',
            ],
            [
                [
                    'bill_id',
                    'item_id',
                    'quantity',
                ],
                'integer',
            ],
            [
                [
                    'bill_id',
                    'item_id',
                ],
                'unique',
                'targetAttribute' => ['bill_id', 'item_id'],
            ],
            [
                'bill_id',
                'exist',
                'skipOnError' => true,
                'targetClass' => Bill::className(),
                'targetAttribute' => ['bill_id' => 'id'],
            ],
            [
                'item_id',
                'exist',
                'skipOnError' => true,
                'targetClass' => Item::className(),
                'targetAttribute' => ['item_id' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'bill_id' => 'Bill ID',
            'item_id' => 'Item ID',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * Gets query for [[Bill]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBill()
    {
        return $this->hasOne(Bill::className(), ['id' => 'bill_id'])
            ->inverseOf('billItems');
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id'])
            ->inverseOf('billItems');
    }

    /**
     * Gets total price
     *
     * @return float
     */
    public function getItemTotalPrice()
    {
        return round($this->quantity * $this->item->price, 2);
    }
}
