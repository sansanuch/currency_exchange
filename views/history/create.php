<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HistoryCourses */

$this->title = 'Create History Courses';
$this->params['breadcrumbs'][] = ['label' => 'History Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-courses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
