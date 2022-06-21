<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'wallet_sender_id')->textInput() ?>

    <?= $form->field($model, 'wallet_recepient_id')->textInput() ?>

    <?= $form->field($model, 'wallet_sender_currency')->textInput() ?>

    <?= $form->field($model, 'wallet_recepient_currency')->textInput() ?>

    <?= $form->field($model, 'wallet_sender_minus')->textInput() ?>

    <?= $form->field($model, 'wallet_recepient_plus')->textInput() ?>

    <?= $form->field($model, 'wallet_sender_unique_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wallet_recepient_unique_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sender_user_id')->textInput() ?>

    <?= $form->field($model, 'recepient_user_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
