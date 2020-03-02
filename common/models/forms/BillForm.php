<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;
use yii\db\Exception as DbException;
use yii\base\InvalidCallException;
use yii\base\NotSupportedException;

use common\models\Bill;
use common\models\Item;
use common\models\RequisitesTrait;

/**
 * Bill form
 */
class BillForm extends Model
{
    public $name;
    public $address;
    public $itn;
    public $iec;
    public $current_account;
    public $bank;
    public $corresponding_account;
    public $bic;
    public $quantity;
    
    use RequisitesTrait {
        RequisitesTrait::rules as baseRules;
        RequisitesTrait::attributeLabels as baseAttributeLabels;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge($this->baseRules(), [
            ['quantity', 'trim'],
            ['quantity', 'required'],
            ['quantity', 'integer', 'min' => 1],
            ['quantity', 'default', 'value' => 1],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge($this->baseAttributeLabels(), [
            'quantity' => 'Количество',
        ]);
    }

    public function save()
    {
        if (!$this->validate()) {
            return;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $organization = $this->findOrCreateOrganization();
            $bill = new Bill();
            $bill->setDefaultValues();
            $bill->link('payer', $organization);
            $bill->link('items', Item::findOne(['id' => 1]), [
                'quantity' => $this->quantity,
            ]);
        } catch (DbException | InvalidCallException $e) {
            $transaction->rollBack();
            throw $e;
        }

        $transaction->commit();

        $bill->refresh();

        return $bill;
    }

    protected function findOrCreateOrganization() {
        throw new NotSupportedException(
            '"findOrCreateOrganization" is not implemented'
        ); 
    }
}
