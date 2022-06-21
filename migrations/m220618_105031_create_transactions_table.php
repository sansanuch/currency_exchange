<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transactions_history}}`.
 */
class m220618_105031_create_transactions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transactions}}', [
            'id' => $this->primaryKey(),
            'wallet_sender_id' => $this->integer(),
            'wallet_recepient_id' => $this->integer(),
            'wallet_sender_currency' => $this->integer(),
            'wallet_recepient_currency' => $this->integer(),
            'wallet_sender_minus' => $this->float(),
            'wallet_recepient_plus' => $this->float(),
            'wallet_sender_unique_id' => $this->string(), 
            'wallet_recepient_unique_id' => $this->string(), 
            'sender_user_id' => $this->integer(),
            'recepient_user_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transactions}}');
    }
}
