<?php

namespace app\controllers;
use app\models\Wallet; 
use app\service_layer\ExchangeConverter; 

class ExchangeController extends \yii\web\Controller
{
    public $validation_error = []; 

    public function actionIndex()
    {
        $user_id = \Yii::$app->user->getId();
        
        $user_wallet = Wallet::find()
            ->where(['user_id' => $user_id])
            ->all();
       
        $other_user_wallet = Wallet::find()->where(['!=', 'user_id', $user_id])->all();
        
        return $this->render('index', [
            'user_wallet' => $user_wallet, 
            'other_user_wallet' => $other_user_wallet
        ]);
    }

    public function actionExchange()
    {   
        $your_wallet_id = \Yii::$app->request->post('your_wallet');
        $recepient_wallet_id = \Yii::$app->request->post('recepient_wallet');
        $amount = \Yii::$app->request->post('amount');
        $current_user_id = \Yii::$app->user->getId();

        $exchange_converter = new ExchangeConverter(); 
        
        $wallets = 
            $exchange_converter->checkWalletsAndBalance($amount, $your_wallet_id, $recepient_wallet_id, $current_user_id); 
   
        if($wallets){
            $rate = $exchange_converter->getExchangeRate();

            if($rate){
                $wallets_rate = $exchange_converter->getRatesForWallets($wallets, $rate);

                $transaction_data = 
                    $exchange_converter->exchangeAlgorithm($amount, $wallets_rate, $wallets);
            
                $exchange_converter->exchangeTransaction($transaction_data);     
                \Yii::$app->getSession()->setFlash('success', "The operation was successful");
                
                return $this->render("exchange");
            }   
        }
    }
}
