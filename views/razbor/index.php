<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Разборы';
$this->params['breadcrumbs'][] = "Разборы";
?>
<div class="razbor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить разбор', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'razbor_id',
            'title',
//            'creation_date',
            'razbor_date',
            'code',
            // 'short_description',
            // 'sort',
            // 'tags',
             'razbor_num',
             'youtube_url:url',
            // 'activities_str',
            // 'trainers_str',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
