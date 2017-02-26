<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тренеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trainers-page">

    <h1><?= Html::encode($this->title) ?></h1>

    <? if(!Yii::$app->user->isGuest) : ?>
    <p>
        <?= Html::a('Добавить тренера', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <? endif; ?>
    
    <?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            "itemView" => "_view",
            "summary" => ""
        ]);
    ?>
</div>
