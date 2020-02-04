<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%organization}}`.
 */
class m200130_023908_create_organization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%organization}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Название организации'),
            'address' => $this->string(255)->notNull()->comment('Адрес организации'),
            'itn' => $this->char(12)->notNull()->comment('ИНН'),
            'iec' => $this->char(9)->comment('КПП'),
            'current_account' => $this->char(20)->notNull()->comment('Расчетный счет'),
            'bank' => $this->string(255)->notNull()->comment('Название банка'),
            'corresponding_account' => $this->char(20)->notNull()->comment('Кор. счет'),
            'bic' => $this->char(9)->notNull()->comment('БИК'),
        ]);
        $this->createIndex(
            'idx-organization-itn',
            '{{%organization}}',
            'itn'
        );
        $this->createIndex(
            'idx-organization-unique-itn-iec',
            '{{%organization}}',
            ['itn', 'iec'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-organization-itn',
            '{{%organization}}'
        );
        $this->dropIndex(
            'idx-organization-unique-itn-iec',
            '{{%organization}}'
        );
        $this->dropTable('{{%organization}}');
    }
}
