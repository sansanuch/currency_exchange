<?php

namespace app\models;

use Yii;
use app\models\Currency; 

/**
 * This is the model class for table "wallets".
 *
 * @property int $id
 * @property string|null $unique_id
 * @property int|null $user_id
 * @property string|null $name
 * @property int|null $currency
 * @property float|null $balance
 */
class Wallet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wallets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'currency_id'], 'integer'],
            [['balance'], 'number'],
            [['unique_id', 'name'], 'string', 'max' => 255],
            [['name', 'unique_id'], 'unique'], 
            [['name'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unique_id' => 'Unique ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'currency_id' => 'Currency',
            'balance' => 'Balance',
        ];
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']); 
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']); 
    }
}
