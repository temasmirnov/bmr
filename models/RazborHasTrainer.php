<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "razbor_has_trainer".
 *
 * @property integer $razbor_id
 * @property integer $trainer_id
 *
 * @property Razbor $razbor
 * @property Trainer $trainer
 */
class RazborHasTrainer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'razbor_has_trainer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['razbor_id', 'trainer_id'], 'required'],
            [['razbor_id', 'trainer_id'], 'integer'],
            [['razbor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Razbor::className(), 'targetAttribute' => ['razbor_id' => 'razbor_id']],
            [['trainer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trainer::className(), 'targetAttribute' => ['trainer_id' => 'trainer_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'razbor_id' => 'Razbor ID',
            'trainer_id' => 'Trainer ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRazbor()
    {
        return $this->hasOne(Razbor::className(), ['razbor_id' => 'razbor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainer()
    {
        return $this->hasOne(Trainer::className(), ['trainer_id' => 'trainer_id']);
    }
}
