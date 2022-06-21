<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transaction;

/**
 * SearchTransaction represents the model behind the search form of `app\models\Transaction`.
 */
class SearchTransaction extends Transaction
{

    public $usersender;
    public $userrecepient; 
    public $currencysender;
    public $currencyrecepient;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'wallet_sender_id', 'wallet_recepient_id', 'wallet_sender_currency', 'wallet_recepient_currency', 'sender_user_id', 'recepient_user_id'], 'integer'],
            [['wallet_sender_minus', 'wallet_recepient_plus'], 'number'],
            [['wallet_sender_unique_id', 'wallet_recepient_unique_id', 'usersender', 'userrecepient', 'currencysender', 'currencyrecepient'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Transaction::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('usersender');
        $query->joinWith('userrecepient');
        $query->joinWith('currencysender');
        $query->joinWith('currencyrecepient');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'wallet_sender_id' => $this->wallet_sender_id,
            'wallet_recepient_id' => $this->wallet_recepient_id,
            'wallet_sender_currency' => $this->wallet_sender_currency,
            'wallet_recepient_currency' => $this->wallet_recepient_currency,
            'wallet_sender_minus' => $this->wallet_sender_minus,
            'wallet_recepient_plus' => $this->wallet_recepient_plus,
            'sender_user_id' => $this->sender_user_id,
            'recepient_user_id' => $this->recepient_user_id,
        ]);

        //$query->andFilterWhere(['like', 'user.email', $this->user]);
       
        $query->andFilterWhere(['like', 'currencies.title', $this->currencysender]);
        $query->andFilterWhere(['like', 'currencies.title', $this->currencyrecepient]);

        $query->andFilterWhere(['like', 'user.email', $this->usersender]);
        $query->andFilterWhere(['like', 'user.email', $this->userrecepient]);

        $query->andFilterWhere(['like', 'wallet_sender_unique_id', $this->wallet_sender_unique_id])
            ->andFilterWhere(['like', 'wallet_recepient_unique_id', $this->wallet_recepient_unique_id]);

        return $dataProvider;
    }
}
