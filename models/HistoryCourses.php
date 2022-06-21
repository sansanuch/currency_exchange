<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history_courses".
 *
 * @property int $id
 * @property int|null $currency
 * @property float|null $dollar
 * @property string|null $created_at
 */
class HistoryCourses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'history_courses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['currency_id'], 'integer'],
            [['dollar'], 'number'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currency' => 'Currency',
            'dollar' => 'Dollar',
            'created_at' => 'Created At',
        ];
    }
}
