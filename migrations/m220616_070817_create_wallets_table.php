<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%wallets}}`.
 */
class m220616_070817_create_wallets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%wallets}}', [
            'id' => $this->primaryKey(),
            'unique_id' => $this->string(),
            'user_id' => $this->integer(), 
            'name' => $this->string(), 
            'currency_id' => $this->integer(), 
            'balance' => $this->float()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%wallets}}');
    }
}
