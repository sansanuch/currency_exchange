<?php

namespace app\modules\exchange_rate\controllers;

use yii\web\Controller;
use yii\httpclient\Client;
/**
 * Default controller for the `exchange_rate` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $request = \Yii::$app->request;

        $API_KEY = \Yii::$app->params['API_KEY']; 
        $url = \Yii::$app->params['api_url'].$API_KEY;

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->send();
        
        if($request->isAjax){
            return $response->content;
        }else{
            return $response;
        }  
    }
}
