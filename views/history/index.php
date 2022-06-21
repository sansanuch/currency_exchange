<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchHistoryCourses */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'History Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-courses-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'currency',
                'value'=> function(app\models\HistoryCourses $model){
                    return \Yii::$app->params['currencies_all'][$model->currency_id+1];
                }  
            ],
            'dollar',
            'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, \app\models\HistoryCourses $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>
</div>
