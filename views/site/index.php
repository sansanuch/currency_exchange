<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
$this->title = 'My Yii Application';
$this->registerJsFile(
    '@web/js/main.js',
    ['depends' => [\yii\web\JqueryAsset::class]]
);
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class = "col-lg-12 text-center">
            <?php if (Yii::$app->user->isGuest): ?>
                <p class = 'lead'>You must log in or register</p>
                <?= Html::a('Login', ['site/login'], ['class' => 'btn btn-lg btn-warning']) ?>
                <?= Html::a('Signup', ['site/signup'], ['class' => 'btn btn-lg btn-primary']) ?>
            <?php else: ?>
                <?= Html::a('Сreate a wallet', ['wallet/create'], ['class' => 'btn btn-lg btn-success']) ?>
                <?= Html::a('List of wallets', ['wallet/index'], ['class' => 'btn btn-lg btn-success']) ?>
                <?= Html::a('History exchange rates', ['history/index'], ['class' => 'btn btn-lg btn-success']) ?>
                <?= Html::a('Currency exchange', ['exchange/index'], ['class' => 'btn btn-lg btn-success']) ?>
                <?= Html::a('Transactions history', ['transaction/index'], ['class' => 'btn btn-lg btn-success']) ?>
            <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Welcome!</h1>
        <h2>Exchange rate<h2/>
        <div class="card">
            <div class="card-body" id = "crypto_currency_container">
            </div>
            <div class="row">
                <div class = "col-lg-12 text-center">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <?= Html::a('Save rate', ['rate/index'], ['class' => 'btn btn-lg btn-outline-success','id' => 'save_course']) ?>
                <?php endif ?>   
                    <a class = "btn btn-lg btn-outline-success" id = "refresh_course">Refresh course</a>
                </div>
            </div>
        </div>
    </div>
</div>
