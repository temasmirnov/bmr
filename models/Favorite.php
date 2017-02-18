<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "favorite".
 *
 * @property integer $favorite_id
 * @property integer $user_id
 * @property integer $razbor_id
 *
 * @property Razbor $razbor
 * @property User $user
 */
class Favorite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'favorite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'razbor_id'], 'required'],
            [['user_id', 'razbor_id'], 'integer'],
            [['razbor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Razbor::className(), 'targetAttribute' => ['razbor_id' => 'razbor_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'favorite_id' => 'Favorite ID',
            'user_id' => 'User ID',
            'razbor_id' => 'Razbor ID',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
}
