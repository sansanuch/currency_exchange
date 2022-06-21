<?php

namespace app\models;

use Yii;
use app\models\Currency;
use app\models\User;

/**
 * This is the model class for table "transactions".
 *
 * @property int $id
 * @property int|null $wallet_sender_id
 * @property int|null $wallet_recepient_id
 * @property int|null $wallet_sender_currency
 * @property int|null $wallet_recepient_currency
 * @property float|null $wallet_sender_minus
 * @property float|null $wallet_recepient_plus
 * @property string|null $wallet_sender_unique_id
 * @property string|null $wallet_recepient_unique_id
 * @property int|null $sender_user_id
 * @property int|null $recepient_user_id
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wallet_sender_id', 'wallet_recepient_id', 'wallet_sender_currency', 'wallet_recepient_currency', 'sender_user_id', 'recepient_user_id'], 'integer'],
            [['wallet_sender_minus', 'wallet_recepient_plus'], 'number'],
            [['wallet_sender_unique_id', 'wallet_recepient_unique_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wallet_sender_id' => 'Wallet Sender ID',
            'wallet_recepient_id' => 'Wallet Recepient ID',
            'wallet_sender_currency' => 'Wallet Sender Currency',
            'wallet_recepient_currency' => 'Wallet Recepient Currency',
            'wallet_sender_minus' => 'Wallet Sender Minus',
            'wallet_recepient_plus' => 'Wallet Recepient Plus',
            'wallet_sender_unique_id' => 'Wallet Sender Unique ID',
            'wallet_recepient_unique_id' => 'Wallet Recepient Unique ID',
            'sender_user_id' => 'Sender User ID',
            'recepient_user_id' => 'Recepient User ID',
        ];
    }

    public function getCurrencysender()
    {
        return $this->hasOne(Currency::className(), ['id' => 'wallet_sender_currency'])->from(['currencies' => Currency::tableName()]); 
    }

    public function getCurrencyrecepient()
    {
        return $this->hasOne(Currency::className(), ['id' => 'wallet_recepient_currency'])->from(['currencies' => Currency::tableName()]); 
    }

    public function getUsersender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_user_id'])->from(['user' => User::tableName()]); 
    }

   
    public function getUserrecepient()
    {
        return $this->hasOne(User::className(), ['id' => 'recepient_user_id'])->from(['user' => User::tableName()]); 
    }
}
