<?php

namespace app\controllers;

use yii\httpclient\Client;
use app\models\HistoryCourses; 

class RateController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $CRYPTO_CURRENCIES = \Yii::$app->params['currencies_crypto']; 

        $response_rate = \Yii::$app->getModule('exchange_rate')->runAction('default/index');
        
        if ($response_rate->isOk) {
            for($i = 0; $i < count($CRYPTO_CURRENCIES); $i++){
                $history = new HistoryCourses(); 
                $index = $CRYPTO_CURRENCIES[$i];
                $history->currency_id = $i;
                $history->user_id = \Yii::$app->user->getId();
                $history->dollar = floatval($response_rate->data['rates'][$index]);
               
                $history->save(); 
            }

            \Yii::$app->getSession()->setFlash('success', 'Rates save successfully into DB');
        }else{
            \Yii::$app->getSession()->setFlash('error', 'ERROR!');
        }
     
        return $this->goHome();
    }

}
