<?php
use yii\helpers\Html;
?>

<div id="message">
    <?= Yii::$app->session->getFlash('success');?>
</div>
<div class = "row text-center">
    <div class = "col-lg-12 text-center">
        <?= Html::a('GO HOME', ['site/index'], ['class' => 'btn btn-lg btn-success']) ?>
        <?= Html::a('Currency exchange', ['exchange/index'], ['class' => 'btn btn-lg btn-success']) ?>
    </div>
</div>