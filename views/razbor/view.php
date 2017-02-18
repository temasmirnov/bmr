<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Razbor */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Разборы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="razbor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->razbor_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->razbor_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот разбор?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'razbor_id',
            'title',
            'razbor_date',
            'code',
            'short_description',
            'sort',
            'tags',
            'razbor_num',
            [
                'label' => $model->getAttributeLabel('youtube_url'),
                'format' => 'raw',
                'value' => "<a target='blank' href='{$model->youtube_url}'>{$model->youtube_url}</a>"
            ],
            'activities_str',
            'trainers_str',
        ],
    ]) ?>

</div>
