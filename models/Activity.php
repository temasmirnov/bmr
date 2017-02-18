<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property integer $activity_id
 * @property string $title
 *
 * @property RazborHasActivity[] $razborHasActivities
 * @property Razbor[] $razbors
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activity_id' => 'Activity ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRazborHasActivities()
    {
        return $this->hasMany(RazborHasActivity::className(), ['activity_id' => 'activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRazbors()
    {
        return $this->hasMany(Razbor::className(), ['razbor_id' => 'razbor_id'])->viaTable('razbor_has_activity', ['activity_id' => 'activity_id']);
    }
}
