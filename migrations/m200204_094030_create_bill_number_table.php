<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bill_number}}`.
 */
class m200204_094030_create_bill_number_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /* Concurrency issues possible */

        /*
        $this->createTable('{{%bill_number}}', [
            'bill_number' => $this->smallInteger()->notNull(),
            'bill_year' => $this->smallInteger()->notNull(),
            'PRIMARY KEY(bill_number, bill_year)',
        ]);
        $storedFunction = ('
            CREATE FUNCTION get_next_bill_number() RETURNS SMALLINT
            BEGIN
                DECLARE last_bill_number SMALLINT;
                DECLARE last_bill_year SMALLINT;
                DECLARE current_year SMALLINT;

                SELECT YEAR(CURRENT_DATE()) INTO current_year;
                SELECT MAX(`bill_number`), `bill_year`
                    INTO last_bill_number, last_bill_year
                    FROM `bill_number`
                    GROUP BY `bill_year`
                    HAVING `bill_year` = current_year;

                IF last_bill_number IS NULL
                THEN
                    SET last_bill_number = 1;
                ELSE
                    SET last_bill_number = last_bill_number + 1;
                END IF;
                
                INSERT INTO `bill_number` (`bill_number`, `bill_year`)
                    VALUES (last_bill_number, YEAR(CURRENT_DATE()));
                
                RETURN last_bill_number;
            END;'
        );
        */
        $this->createTable('{{%bill_number}}', [
            'last_bill_number' => $this->smallInteger()->notNull(),
            'last_bill_year' => $this->smallInteger()->notNull(),
        ]);
        $storedFunction = ('
            CREATE FUNCTION get_next_bill_number() RETURNS SMALLINT
            BEGIN
                DECLARE bill_number SMALLINT;
                DECLARE bill_year SMALLINT;
                DECLARE current_year SMALLINT;

                SELECT YEAR(CURRENT_DATE()) INTO current_year;
                SELECT `last_bill_number`, `last_bill_year`
                    INTO bill_number, bill_year
                    FROM `bill_number`
                    LIMIT 1;

                IF bill_number IS NULL AND bill_year IS NULL
                THEN
                    SET bill_number = 1;
                    SET bill_year = current_year;
                    INSERT INTO `bill_number` (`last_bill_number`, `last_bill_year`)
                        VALUES (bill_number, bill_year);
                ELSE
                    IF bill_year != current_year
                    THEN
                        SET bill_number = 1;
                    ELSE
                        SET bill_number = bill_number + 1;
                    END IF;
                
                    SET bill_year = current_year;
                
                    UPDATE `bill_number`
                        SET `last_bill_number` = bill_number, `last_bill_year` = bill_year;
                END IF;
                
                RETURN bill_number;
            END;'
        );
        $this->execute($storedFunction);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP FUNCTION IF EXISTS get_next_bill_number');
        $this->dropTable('{{%bill_number}}');
    }
}
