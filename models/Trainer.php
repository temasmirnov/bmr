<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trainer".
 *
 * @property integer $trainer_id
 * @property string $name
 * @property string $photo
 * @property string $about
 * @property string $income
 *
 * @property RazborHasTrainer[] $razborHasTrainers
 * @property Razbor[] $razbors
 */
class Trainer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trainer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['income'], 'string', 'max' => 45],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['about'], 'string', 'max' => 5000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'trainer_id' => 'Trainer ID',
            'name' => 'Имя',
            'photo' => 'Фото',
            'about' => 'О тренере',
            'income' => 'Доход',
        ];
    }

    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            
            if($this->photo && $insert) {
                $fname = Yii::$app->security->generateRandomString(8) . "." . $this->photo->extension;
                $this->photo->saveAs("images/trainers/" . $fname);
                $this->photo = $fname;
            }
            
            return true;
        }
        
        return false;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRazborHasTrainers()
    {
        return $this->hasMany(RazborHasTrainer::className(), ['trainer_id' => 'trainer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRazbors()
    {
        return $this->hasMany(Razbor::className(), ['razbor_id' => 'razbor_id'])->viaTable('razbor_has_trainer', ['trainer_id' => 'trainer_id']);
    }
}
