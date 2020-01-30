<?php

use yii\db\Migration;

use common\models\User;

/**
 * Class m200129_223902_add_default_user
 */
class m200129_223902_add_default_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->getDb()->beginTransaction();

        $user = Yii::createObject([
            'class' => User::className(),
            'scenario' => 'create',
            'email' => 'admin@site.com',
            'username' => 'admin',
            'password' => 'admin',
            'status' => User::STATUS_ACTIVE,
        ]);

        if (!$user->insert(false)) {
            $transaction->rollBack();
            return false;
        }

        $transaction->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200129_223902_add_default_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200129_223902_add_default_user cannot be reverted.\n";

        return false;
    }
    */
}
