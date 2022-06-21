<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistoryCourses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="history-courses-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'currency_id')->dropDownList(\Yii::$app->params['currencies_crypto']) ?>

    <?= $form->field($model, 'dollar')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
