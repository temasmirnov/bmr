<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "razbor_has_activity".
 *
 * @property integer $razbor_id
 * @property integer $activity_id
 *
 * @property Activity $activity
 * @property Razbor $razbor
 */
class RazborHasActivity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'razbor_has_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['razbor_id', 'activity_id'], 'required'],
            [['razbor_id', 'activity_id'], 'integer'],
            [['activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_id' => 'activity_id']],
            [['razbor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Razbor::className(), 'targetAttribute' => ['razbor_id' => 'razbor_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'razbor_id' => 'Razbor ID',
            'activity_id' => 'Activity ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['activity_id' => 'activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRazbor()
    {
        return $this->hasOne(Razbor::className(), ['razbor_id' => 'razbor_id']);
    }
}
