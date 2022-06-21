<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%history_courses}}`.
 */
class m220616_104813_create_history_courses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%history_courses}}', [
            'id' => $this->primaryKey(),
            'currency_id' => $this->integer(), 
            'dollar' => $this->float(), 
            'user_id' => $this->integer(),
            'created_at' => $this->dateTime()->defaultValue(new \yii\db\Expression('NOW()')),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%history_courses}}');
    }
}
