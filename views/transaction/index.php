<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchTransaction */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'wallet_sender_unique_id',

            [
                'attribute' => 'usersender',
                'label' => 'User name',
                'value' => 'usersender.username',
            ],
            [
                'attribute' => 'usersender',
                'label' => 'Sender(email)',
                'value' => 'usersender.email',
            ],
            'wallet_sender_minus',
            [
                'attribute'=>'currencysender',
                'label' => 'Currency',
                'value' => 'currencysender.title',
            ],
            [
                'label' => "", 
                "format" => 'raw',
                'value' => function(){
                    return "<span style = 'font-size: 50px'>⇒</span>";
                }
            ],

            //'wallet_sender_id',
            //'wallet_recepient_id',
            //'wallet_sender_currency',

           
            //'wallet_recepient_currency',

            'wallet_recepient_unique_id',
            [
                'attribute'=>'userrecepient',
                'label' => 'User name',
                'value' => 'userrecepient.username',
            ],
            [
                'attribute'=>'userrecepient',
                'label' => 'Recepient(email)',
                'value' => 'userrecepient.email',
            ],
            'wallet_recepient_plus',
            [
                'attribute'=>'currencyrecepient',
                'label' => 'Currency',
                'value' => 'currencyrecepient.title',
            ],
            
            //'sender_user_id',
            //'recepient_user_id',
        ],
    ]); ?>


</div>
