<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Trainer */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Тренеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->trainer_id]];
?>
<div class="trainer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
