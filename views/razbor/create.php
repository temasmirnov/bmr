<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Razbor */

$this->title = 'Новый разбор';
$this->params['breadcrumbs'][] = ['label' => 'Разборы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="razbor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
