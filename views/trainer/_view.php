<? use yii\helpers\Html; ?>

<div class="trainer clearfix">
    <img class="trainer-photo" align="left" alt="<?= $model->name; ?>" src="<?= app\helpers\CImage::getImage($model->photo, "trainers", 200, 200); ?>" />
    
    <div class="trainer-data">
        <h3>
            <?= str_replace(" ", "&nbsp;", $model->name); ?>
        </h3>

        <? if($model->birthday) : ?>
            <?= $model->age; ?>

            <? echo \Yii::t('app', '{n, plural, =0{лет} =1{год} other{лет}}', array(
                'n' => $model->age
            ));
            ?>
        <? endif; ?>

        <p class="trainer-about">
            <?= $model->about; ?>
        </p>

        <? if(!Yii::$app->user->isGuest) : ?>
            <?= Html::a('Редактировать', ['update', 'id' => $model->trainer_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['trainer/delete', 'id' => $model->trainer_id], [
                'data' => [
                    'method' => 'post',
                    'confirm' => "Вы уверены, что хотите удалить этого тренера?"
                ],
                'class' => 'btn btn-danger'
            ])?>
        <? endif; ?>
    </div>
</div>