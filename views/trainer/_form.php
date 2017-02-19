<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Trainer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trainer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'photo')->fileInput() ?>
    <? if($model->photo) : ?>
        <img style="margin-bottom:20px;" alt="" src="/images/trainers/<?= $model->photo; ?>" />
    <? endif; ?>

    <?= $form->field($model, 'about')->textarea() ?>

    <?= $form->field($model, 'income')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
