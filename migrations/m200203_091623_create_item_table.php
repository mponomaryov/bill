<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%item}}`.
 */
class m200203_091623_create_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%item}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'price' => $this->money(10,2)->notNull(),
        ]);
        $this->createIndex(
            'idx-item-unique-name',
            '{{%item}}',
            'name',
            true
        );
        $this->insert('{{%item}}', [
            'name' => 'Товар/услуга/работа по-умолчанию',
            'price' => '99.99',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-item-unique-name',
            '{{%item}}'
        );
        $this->dropTable('{{%item}}');
    }
}
