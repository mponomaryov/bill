<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%item}}".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 *
 * @property BillItem[] $billItems
 * @property Bill[] $bills
 */
class Item extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%item}}';
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
                    'price',
                ],
                'required',
            ],
            [
                'price',
                'number',
            ],
            [
                'name',
                'string',
                'max' => 255,
            ],
            [
                'name',
                'unique',
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
            'price' => 'Price',
        ];
    }

    /**
     * Gets query for [[BillItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBillItems()
    {
        return $this->hasMany(BillItem::className(), ['item_id' => 'id'])
            ->inverseOf('item');
    }

    /**
     * Gets query for [[Bills]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBills()
    {
        return $this->hasMany(Bill::className(), ['id' => 'bill_id'])
            ->viaTable('{{%bill_item}}', ['item_id' => 'id']);
    }
}
