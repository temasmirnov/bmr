<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "note".
 *
 * @property integer $note_id
 * @property string $note
 * @property integer $razbor_id
 * @property integer $user_id
 *
 * @property Razbor $razbor
 * @property User $user
 */
class Note extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'note';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['razbor_id', 'user_id'], 'required'],
            [['razbor_id', 'user_id'], 'integer'],
            [['note'], 'string', 'max' => 5000],
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
            'note_id' => 'Note ID',
            'note' => 'Note',
            'razbor_id' => 'Razbor ID',
            'user_id' => 'User ID',
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
