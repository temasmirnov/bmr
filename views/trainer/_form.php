<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\helpers\CImage;

/* @var $this yii\web\View */
/* @var $model app\models\Trainer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trainer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= Html::activeLabel($model, "photo"); ?>
    <? if($model->photo) : ?>
    <div>
        <img style="margin-bottom:20px;" alt="" src="<?= CImage::getImage($model->photo, "trainers", 100, 100); ?>" />
    </div>
    <? endif; ?>
    <?= $form->field($model, 'photo')->fileInput()->label(false) ?>
    

    <?= $form->field($model, 'about')->textarea() ?>

    <?= $form->field($model, 'income')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
