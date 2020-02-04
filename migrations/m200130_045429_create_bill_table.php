<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bill}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%organization}}`
 */
class m200130_045429_create_bill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bill}}', [
            'id' => $this->primaryKey(),
            'payer_id' => $this->integer()->notNull(),
            'bill_number' => $this->smallInteger()->unsigned()->notNull(),
            'created_at' => $this->date()->notNull(),
        ]);

        // creates index for column `payer_id`
        $this->createIndex(
            '{{%idx-bill-payer_id}}',
            '{{%bill}}',
            'payer_id'
        );

        // add foreign key for table `{{%organization}}`
        $this->addForeignKey(
            '{{%fk-bill-payer_id}}',
            '{{%bill}}',
            'payer_id',
            '{{%organization}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%organization}}`
        $this->dropForeignKey(
            '{{%fk-bill-payer_id}}',
            '{{%bill}}'
        );

        // drops index for column `payer_id`
        $this->dropIndex(
            '{{%idx-bill-payer_id}}',
            '{{%bill}}'
        );

        $this->dropTable('{{%bill}}');
    }
}
