<?php

namespace app\controllers;
use Yii;
use app\models\Currency; 
use app\models\User;
use app\models\Wallet; 

class GenerateController extends \yii\web\Controller
{
    public function actionGenerate()
    {
        $this->addCurrency(); 
        $this->addUser();
        $this->addWallet(); 
    }

    public function addCurrency()
    {
        $currencies_params = Yii::$app->params['currencies_all']; 

        $checkDB = Currency::find()->all();
        
        if(empty($checkDB)){
            for($i = 1; $i < count($currencies_params); $i++){
                $currency = new Currency();
                $currency->title = $currencies_params[$i]; 
                $currency->save(); 
            } 

            echo "Currencies generated successfully<br>";
            echo "----------------------------------------------------------<br>";
        }
    }

    public function addUser() 
    {
        $checkDB = User::find()->all();
        
        if(empty($checkDB)){
            for($i = 1; $i <= 3; $i++){
                $user = new User();
                $user->username = 'test'.$i;
                $user->email = "test".$i."@gmail.com";
                $user->setPassword('12345678');
                $user->generateAuthKey();

                if ($user->save()) {
                    echo "users test$i  generated - password 12345678<br>";
                    echo "----------------------------------------------------------<br>";
                }
            }
        }
   }

   public function addWallet()
   {
        $checkDB = Wallet::find()->all();
            
        if(empty($checkDB)){
            for($i = 1; $i < 4 ; $i++){
                for($c = 1; $c <= 5; $c++){
                    $unique_id = \Yii::$app->security->generateRandomString(12);
                    $user_id = $i;
                    $balance = 100;
                    $name = "test".$c.$i; 
                    $currency_id = intval($c); 
                    
                    Yii::$app->db->createCommand()->insert('wallets', [
                        'name' => $name,
                        'unique_id' => $unique_id,
                        'balance' => $balance, 
                        'user_id' => $user_id,
                        'currency_id' => $currency_id
                    ])->execute();
                    
                    $currency = \Yii::$app->params['currencies_all'][$c]; 
                    echo "wallet test$i - user_id = $i, balance 100 $currency generated <br>";
                    echo "----------------------------------------------------------<br>";
                }
            }
        }
   }


}
