<?php

namespace app\models;

use Yii;
use Yii\web\UploadedFile;
use app\helpers\CImage;

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
    public $oldRecord;
    
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
    
    public function afterFind() {
        $this->oldRecord = clone $this;
        return parent::afterFind();
    }

    public function beforeSave($insert) {
        if(parent::beforeSave($insert)) {
            // добавление записи
            if($this->photo && $insert) {
                $fname = Yii::$app->security->generateRandomString(8) . "." . $this->photo->extension;
                $this->photo->saveAs("images/trainers/" . $fname);
                $this->photo = $fname;
            }
            
            // редактирование записи
            if($this->photo instanceof UploadedFile && !$insert) {                
                // удаляем старый файл
                $fpath = Yii::$app->basePath . "/web/images/trainers/" . $this->oldRecord->photo;
                if($this->photo && file_exists($fpath)) {
                    unlink($fpath);
                }
                
                $fname = Yii::$app->security->generateRandomString(8) . "." . $this->photo->extension;
                $this->photo->saveAs("images/trainers/" . $fname);
                $this->photo = $fname;
            }
            
            return true;
        }
        
        return false;
    }
    
    public function afterDelete() {        
        $image_path = Yii::$app->basePath . '/web/images/trainers/' . $this->oldRecord->photo;
        if(file_exists($image_path) && is_file($image_path)) {
            CImage::removeResizedImages($this->oldRecord->photo, 'trainers');
            unlink($image_path);
        }
        
        return true;
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
