<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bill_item}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%bill}}`
 * - `{{%item}}`
 */
class m200203_100907_create_junction_table_for_bill_and_item_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bill_item}}', [
            'bill_id' => $this->integer(),
            'item_id' => $this->integer(),
            'quantity' => $this->smallInteger()->unsigned()->notNull(),
            'PRIMARY KEY(bill_id, item_id)',
        ]);

        // creates index for column `bill_id`
        $this->createIndex(
            '{{%idx-bill_item-bill_id}}',
            '{{%bill_item}}',
            'bill_id'
        );

        // add foreign key for table `{{%bill}}`
        $this->addForeignKey(
            '{{%fk-bill_item-bill_id}}',
            '{{%bill_item}}',
            'bill_id',
            '{{%bill}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        // creates index for column `item_id`
        $this->createIndex(
            '{{%idx-bill_item-item_id}}',
            '{{%bill_item}}',
            'item_id'
        );

        // add foreign key for table `{{%item}}`
        $this->addForeignKey(
            '{{%fk-bill_item-item_id}}',
            '{{%bill_item}}',
            'item_id',
            '{{%item}}',
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
        // drops foreign key for table `{{%bill}}`
        $this->dropForeignKey(
            '{{%fk-bill_item-bill_id}}',
            '{{%bill_item}}'
        );

        // drops index for column `bill_id`
        $this->dropIndex(
            '{{%idx-bill_item-bill_id}}',
            '{{%bill_item}}'
        );

        // drops foreign key for table `{{%item}}`
        $this->dropForeignKey(
            '{{%fk-bill_item-item_id}}',
            '{{%bill_item}}'
        );

        // drops index for column `item_id`
        $this->dropIndex(
            '{{%idx-bill_item-item_id}}',
            '{{%bill_item}}'
        );

        $this->dropTable('{{%bill_item}}');
    }
}
