<?php

namespace app\service_layer;

use app\models\Wallet; 
use app\models\Transaction; 

class ExchangeConverter{
    public $validation_error = []; 

    public function checkWalletsAndBalance($amount, $your_wallet_id, $recepient_wallet_id, $current_user_id)
    {
        $exist_wallets = 
            $this->checkExistWallets($your_wallet_id, $recepient_wallet_id, $current_user_id);

        if($exist_wallets){
            $balance_ok = 
                $this->checkYourWalletBalance($amount, $your_wallet_id, $current_user_id); 

            if($balance_ok){
                return $exist_wallets; 
            }
        }

        return false; 
    }

    public function checkYourWalletBalance($amount, $your_wallet_id, $current_user_id)
    {
        $your_wallet_info = Wallet::find()
                ->where(['id' => $your_wallet_id])
                ->andWhere(['user_id' => $current_user_id])
                ->one();

        if($your_wallet_info){
            $your_wallet_balance = $your_wallet_info->balance;

            if($your_wallet_balance < $amount){
                $this->validation_error["balance_error"] = 
                    "You do not have this amount in your account";
                
                return false; 
            }
        }
        return true; 
    }

    public function checkExistWallets($your_wallet_id, $recepient_wallet_id, $current_user_id)
    {
        $your_wallet_info = Wallet::find()
                ->where(['id' => $your_wallet_id])
                ->andWhere(['user_id' => $current_user_id])
                ->one();

        if($your_wallet_info){
            $recepient_wallet_info = Wallet::find()
                ->where(['id' => $recepient_wallet_id])
                ->one(); 

            if(!$recepient_wallet_info){
                $this->validation_error["recepient_wallet_error"] = 
                "Recepient wallet does not exist";
                
                return false; 
            }
        }else{
            $this->validation_error["your_wallet_error"] = 
                "Your wallet does not exist";

            return false; 
        }

        return [
            "your_wallet_info" => $your_wallet_info, 
            "recepient_wallet_info" => $recepient_wallet_info 
        ]; 
    }

    public function getExchangeRate()
    {
        $response_rate =
             \Yii::$app->getModule('exchange_rate')->runAction('default/index');
       
        if(!$response_rate){
            $this->validation_error["rate_error"] = "Rate error"; 

            return false; 
        }

        return $response_rate;
    }

    public function getRatesForWallets($wallets, $rate)
    {
        $CRYPTO_CURRENCIES = \Yii::$app->params['currencies_all']; 

        $currency_name_your_wallet = 
          $CRYPTO_CURRENCIES[$wallets["your_wallet_info"]["currency_id"]];

        $currency_name_recepient_wallet = 
            $CRYPTO_CURRENCIES[$wallets["recepient_wallet_info"]["currency_id"]];
        
        $wallets_rate["currency"]["your_wallet"] = $currency_name_your_wallet;
        $wallets_rate["currency"]["recepient_wallet"] = $currency_name_recepient_wallet;  
        
        $wallets_rate["rate"]["your_wallet"] = 
            isset($rate->data['rates'][$currency_name_your_wallet], $rate->data['rates'])? 
            $rate->data['rates'][$currency_name_your_wallet] : 1; 
        
        $wallets_rate["rate"]["recepient_wallet"] = 
            isset($rate->data['rates'][$currency_name_recepient_wallet], $rate->data['rates']) ? 
            $rate->data['rates'][$currency_name_recepient_wallet] : 1; 
        
        return $wallets_rate; 
    }

    public function exchangeAlgorithm($amount, $wallets_rate, $wallets)
    {
        $convertResult = 0; 
        
        $yourCurrency = $wallets_rate["currency"]["your_wallet"]; 
        $recepientCurrency = $wallets_rate["currency"]["recepient_wallet"]; 
        $yourCurrencyRate = $wallets_rate["rate"]["your_wallet"]; 
        $recepientCurrencyRate = $wallets_rate["rate"]["recepient_wallet"]; 

        if($yourCurrency === "USD" && $recepientCurrency !== "USD"){
            $convertResult = $amount / $recepientCurrencyRate;
        }else if($yourCurrency !== "USD" && $recepientCurrency === "USD"){
            $convertResult = $yourCurrencyRate * $amount;
        }else if($yourCurrency === "USD" && $recepientCurrency === "USD"){
            $convertResult = $amount;
        }else{
            $convertResult = ($yourCurrencyRate * $amount) / $recepientCurrencyRate; 
        }
 
        $transaction_data["minus_your_wallet"] = $amount;
        $transaction_data["plus_recepient_wallet"] = $convertResult; 
        $transaction_data["your_wallet_id"] = $wallets["your_wallet_info"]->id;
        $transaction_data["recepient_wallet_id"] = $wallets["recepient_wallet_info"]->id;
        $transaction_data["your_wallet_unique_id"] = $wallets["your_wallet_info"]->unique_id;
        $transaction_data["recepient_wallet_unique_id"] = $wallets["recepient_wallet_info"]->unique_id;
        $transaction_data["your_wallet_currency"] = $wallets["your_wallet_info"]->currency_id;
        $transaction_data["recepient_wallet_currency"] = $wallets["recepient_wallet_info"]->currency_id;
   
        return $transaction_data; 
    }

    public function exchangeTransaction($transaction_data)
    {   
        $wallet_sender = Wallet::findOne($transaction_data["your_wallet_id"]);
        $wallet_recepient = Wallet::findOne($transaction_data["recepient_wallet_id"]);
        $sender_minus_amount = floatval($transaction_data["minus_your_wallet"]); 
        $recepient_plus_amount = floatval($transaction_data["plus_recepient_wallet"]); 

        Wallet::getDb()->transaction(function() 
                use ($wallet_sender, $wallet_recepient, $sender_minus_amount, $recepient_plus_amount) {

            $wallet_sender->balance =
                $wallet_sender->balance - $sender_minus_amount;

            $wallet_recepient->balance =
                 $wallet_recepient->balance + $recepient_plus_amount;

          
            $wallet_sender->save();
            $wallet_recepient->save();
           
        });

        $this->historyLogTransaction($transaction_data); 
    }

    public function historyLogTransaction($transaction_data)
    {
        $transaction_history = new Transaction(); 

        $transaction_history->wallet_sender_id = 
            $transaction_data["your_wallet_id"];

        $transaction_history->wallet_recepient_id = 
            $transaction_data["recepient_wallet_id"];

        $transaction_history->recepient_user_id = 
            Wallet::findOne($transaction_data["recepient_wallet_id"])->user_id;
            
        $transaction_history->sender_user_id = 
            \Yii::$app->user->getId();

        $transaction_history->wallet_sender_currency = 
            $transaction_data["your_wallet_currency"];

        $transaction_history->wallet_recepient_currency = 
            $transaction_data["recepient_wallet_currency"];
        
        $transaction_history->wallet_sender_minus = 
            $transaction_data["minus_your_wallet"];

        $transaction_history->wallet_recepient_plus = 
            $transaction_data["plus_recepient_wallet"];

        $transaction_history->wallet_sender_unique_id = 
            $transaction_data["your_wallet_unique_id"];

        $transaction_history->wallet_recepient_unique_id = 
            $transaction_data["recepient_wallet_unique_id"];

        $transaction_history->save(); 
    }
}