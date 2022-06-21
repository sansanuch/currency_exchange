<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchTransaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'wallet_sender_id') ?>

    <?= $form->field($model, 'wallet_recepient_id') ?>

    <?= $form->field($model, 'wallet_sender_currency') ?>

    <?= $form->field($model, 'wallet_recepient_currency') ?>

    <?php // echo $form->field($model, 'wallet_sender_minus') ?>

    <?php // echo $form->field($model, 'wallet_recepient_plus') ?>

    <?php // echo $form->field($model, 'wallet_sender_unique_id') ?>

    <?php // echo $form->field($model, 'wallet_recepient_unique_id') ?>

    <?php // echo $form->field($model, 'sender_user_id') ?>

    <?php // echo $form->field($model, 'recepient_user_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
