<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Trainer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Тренеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trainer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <? if(!Yii::$app->user->isGuest) : ?>
    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->trainer_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->trainer_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этого тренера?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <? endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'birthday',
            'photo',
            'about',
            'income',
        ],
    ]) ?>

</div>
