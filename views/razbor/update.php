<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Razbor */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Разборы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->razbor_id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="razbor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
